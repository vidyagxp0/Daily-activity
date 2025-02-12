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

    .head-number {
        font-weight: bold;
        font-size: 13px;
        padding-left: 10px;
    }

    .div-data {
        font-size: 13px;
        padding-left: 10px;
        margin-bottom: 10px;
    }
</style>

<body>
    <header>
        <table>
            <tr>
                <td class="w-70 head">
                    EHS & Environment Sustainability Family Report
                </td>
                <td class="w-30">
                    <div class="logo">
                        <img src="https://www.cphi-online.com/Medicef%20Logo-comp306798.jpg" alt=""
                            class="w-50">
                    </div>
                </td>
            </tr>
        </table>
        <table>
            <tr>
                <td class="w-30">
                    <strong>EHS & Environment Sustainability No.</strong>
                </td>
                <td class="w-40">
                    {{ Helpers::divisionNameForQMS($data->division_id) }}/EE/{{ date('Y') }}/{{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}
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
                {{-- <td class="w-30">
                    <strong>Page :</strong> 1 of 1
                </td> --}}
            </tr>
        </table>
    </footer>

    <div class="inner-block">
        <div class="content-table">
            <div class="block">
                <div class="block-head">
                    General Information
                </div>
                <table>
                    <tr>
                        <th class="w-20">Record Number</th>
                        <td class="w-30">{{ $data->record_number }} </td>
                        <th class="w-20">Site/Location Code</th>
                        <td class="w-30">
                            @if ($data->division_id)
                                {{ Helpers::getDivisionName($data->division_id) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr> {{ $data->created_at }} added by {{ $data->originator }}
                        <th class="w-20">Initiator</th>
                        <td class="w-30">{{ Helpers::getInitiatorName($data->initiator_id) }}</td>
                        <th class="w-20">Date of Initiation</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->intiation_date) }}</td>
                    </tr>

                    <tr>
                        <th class="w-20">Assigned To</th>
                        <td class="w-30">
                            @if ($data->assign_to)
                                {{ Helpers::getInitiatorName($data->assign_to) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Due Date</th>
                        <td class="w-30">
                            @if ($data->due_date)
                                {{ Helpers::getdateFormat($data->due_date) }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                    </tr>




                </table>

                <label class="head-number" for="Short Description">Short Description</label>
                <div class="div-data">
                    @if ($data->short_description)
                        {{ $data->short_description }}
                    @else
                        Not Applicable
                    @endif
                </div>

                <div class="block-head">
                    EHS Event Details
                </div>

                <table>

                    <tr>
                        <th class="w-20">Type</th>
                        <td class="w-80">
                            @if ($data->Type)
                                {{ $data->Type }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Incident Sub Type</th>
                        <td class="w-80">
                            @if ($data->Incident_Sub_Type)
                                {{ $data->Incident_Sub_Type }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Date Occurred</th>
                        <td class="w-80">
                            @if ($data->Date_Occurred)
                                {{ Helpers::getdateFormat($data->Date_Occurred) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Time Occurred</th>
                        <td class="w-80">
                            @if ($data->Time_Occurred)
                                {{ $data->Time_Occurred }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                </table>

                <div class="block-head">
                    Attached File
                </div>
                <div class="border-table">
                    <table>
                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">File </th>
                        </tr>
                        @if ($data->Attached_File)
                            @foreach (json_decode($data->Attached_File) as $key => $file)
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

                <table>

                    <tr>
                        <th class="w-20">Similar Incidents</th>
                        <td class="w-80">
                            @if ($data->Similar_Incidents)
                                {{ $data->Similar_Incidents }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Date Of Reporting</th>
                        <td class="w-80">
                            @if ($data->Date_Of_Reporting)
                                {{ Helpers::getdateFormat($data->Date_Of_Reporting) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Reporter</th>
                        <td class="w-80">
                            @if ($data->Reporter)
                                {{ Helpers::getInitiatorName($data->Reporter) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                </table>

                <label class="head-number" for="Description">Description</label>
                <div class="div-data">
                    @if ($data->Description)
                        {{ $data->Description }}
                    @else
                        Not Applicable
                    @endif
                </div>

                <label class="head-number" for="Immediate Actions">Immediate Actions</label>
                <div class="div-data">
                    @if ($data->Immediate_Actions)
                        {{ $data->Immediate_Actions }}
                    @else
                        Not Applicable
                    @endif
                </div>
            </div>

            <div class="block">
                <div class="block-head">
                    Detailed Information
                </div>
                <table>
                    <tr>
                        <th class="w-20">Accident Type</th>
                        <td class="w-80">
                            @if ($data->Accident_Type)
                                {{ $data->Accident_Type }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">OSHA Reportable</th>
                        <td class="w-80">
                            @if ($data->OSHA_Reportable)
                                {{ $data->OSHA_Reportable }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">First Lost Work Date</th>
                        <td class="w-80">
                            @if ($data->First_Lost_Work_Date)
                                {{ Helpers::getdateFormat($data->First_Lost_Work_Date) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Last Lost Work Date</th>
                        <td class="w-80">
                            @if ($data->Last_Lost_Work_Date)
                                {{ Helpers::getdateFormat($data->Last_Lost_Work_Date) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">First Restricted Work Date</th>
                        <td class="w-80">
                            @if ($data->First_Restricted_Work_Date)
                                {{ Helpers::getdateFormat($data->First_Restricted_Work_Date) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Last Restricted Work Date</th>
                        <td class="w-80">
                            @if ($data->Last_Restricted_Work_Date)
                                {{ Helpers::getdateFormat($data->Last_Restricted_Work_Date) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Vehicle Type</th>
                        <td class="w-80">
                            @if ($data->Vehicle_Type)
                                {{ $data->Vehicle_Type }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Vehicle Number</th>
                        <td class="w-80">
                            @if ($data->Vehicle_Number)
                                {{ $data->Vehicle_Number }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Litigation</th>
                        <td class="w-80">
                            @if ($data->Litigation)
                                {{ $data->Litigation }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Department</th>
                        <td class="w-80">
                            @if ($data->Department)
                                {{ $data->Department }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>

                <div class="block-head">
                    Involved Persons
                </div>
                <table>
                    <tr>
                        <th class="w-20">Employees Involved</th>
                        <td class="w-80">
                            @if ($data->Employees_Involved)
                                {{ Helpers::getInitiatorName($data->Employees_Involved) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Involved Contractors</th>
                        <td class="w-80">
                            @if ($data->Involved_Contractors)
                                {{ Helpers::getInitiatorName($data->Involved_Contractors) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Attorneys Involved</th>
                        <td class="w-80">
                            @if ($data->Attorneys_Involved)
                                {{ Helpers::getInitiatorName($data->Attorneys_Involved) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Lead Investigator</th>
                        <td class="w-80">
                            @if ($data->Lead_Investigator)
                                {{ Helpers::getInitiatorName($data->Lead_Investigator) }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Line Operator</th>
                        <td class="w-80">
                            @if ($data->Line_Operator)
                                {{ Helpers::getInitiatorName($data->Line_Operator) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Reporter</th>
                        <td class="w-80">
                            @if ($data->Reporter2)
                                {{ Helpers::getInitiatorName($data->Reporter2) }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Supervisor</th>
                        <td class="w-80">
                            @if ($data->Supervisor)
                                {{ Helpers::getInitiatorName($data->Supervisor) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>

                <div class="block-head">
                    Near Miss And Measures
                </div>
                <table>
                    <tr>
                        <th class="w-20">Unsafe Situation</th>
                        <td class="w-80">
                            @if ($data->Unsafe_Situation)
                                {{ $data->Unsafe_Situation }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Safeguarding Measure Taken</th>
                        <td class="w-80">
                            @if ($data->Safeguarding_Measure_Taken)
                                {{ $data->Safeguarding_Measure_Taken }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>

                <div class="block-head">
                    Environmental Information
                </div>
                <table>
                    <tr>
                        <th class="w-20">Environmental Category</th>
                        <td class="w-80">
                            @if ($data->Environmental_Category)
                                {{ $data->Environmental_Category }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Special Weather Conditions</th>
                        <td class="w-80">
                            @if ($data->Special_Weather_Conditions)
                                {{ $data->Special_Weather_Conditions }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Source Of Release Or Spill</th>
                        <td class="w-80">
                            @if ($data->Source_Of_Release_Or_Spill)
                                {{ $data->Source_Of_Release_Or_Spill }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Cause Of Release Or Spill</th>
                        <td class="w-80">
                            @if ($data->Cause_Of_Release_Or_Spill)
                                {{ $data->Cause_Of_Release_Or_Spill }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>

                <label class="head-number" for="Threat Caused By Release/Spill">Threat Caused By Release/Spill</label>
                <div class="div-data">
                    @if ($data->Threat_Caused_By_Release_Spill)
                        {{ $data->Threat_Caused_By_Release_Spill }}
                    @else
                        Not Applicable
                    @endif
                </div>


                <table>
                    <tr>
                        <th class="w-20">Environment Evacuation Ordered</th>
                        <td class="w-80">
                            @if ($data->Environment_Evacuation_Ordered)
                                {{ $data->Environment_Evacuation_Ordered }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Date of Samples Taken</th>
                        <td class="w-80">
                            @if ($data->Date_Samples_Taken)
                                {{ Helpers::getdateFormat($data->Date_Samples_Taken) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Agencys Notified</th>
                        <td class="w-80">
                            @if ($data->Agencys_Notified)
                                {{ $data->Agencys_Notified }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>

                <div class="block-head">
                    Fire Incident
                </div>
                <table>

                    <tr>
                        <th class="w-20">Fire Category</th>
                        <td class="w-80">
                            @if ($data->Fire_Category)
                                {{ $data->Fire_Category }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Fire Evacuation Ordered ?</th>
                        <td class="w-80">
                            @if ($data->Fire_Evacuation_Ordered)
                                {{ $data->Fire_Evacuation_Ordered }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Combat By</th>
                        <td class="w-80">
                            @if ($data->Combat_By)
                                {{ $data->Combat_By }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>

                <label class="head-number" for="Fire Fighting Equipment Used">Fire Fighting Equipment Used</label>
                <div class="div-data">
                    @if ($data->Fire_Fighting_Equipment_Used)
                        {{ $data->Fire_Fighting_Equipment_Used }}
                    @else
                        Not Applicable
                    @endif
                </div>

                <div class="block-head">
                    Event Location
                </div>
                <table>
                    <tr>
                        <th class="w-20">Zone</th>
                        <td class="w-80">
                            @if ($data->zone)
                                {{ $data->zone }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Country</th>
                        <td class="w-80">
                            @if ($data->country)
                                {{ $data->country }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">State</th>
                        <td class="w-80">
                            @if ($data->state)
                                {{ $data->state }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">City</th>
                        <td class="w-80">
                            @if ($data->city)
                                {{ $data->city }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Site Name</th>
                        <td class="w-80">
                            @if ($data->Site_Name)
                                {{ $data->Site_Name }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Building</th>
                        <td class="w-80">
                            @if ($data->Building)
                                {{ $data->Building }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Floor</th>
                        <td class="w-80">
                            @if ($data->Floor)
                                {{ $data->Floor }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Room</th>
                        <td class="w-80">
                            @if ($data->Room)
                                {{ $data->Room }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>

                <label class="head-number" for="Location">Location</label>
                <div class="div-data">
                    @if ($data->Location)
                        {{ $data->Location }}
                    @else
                        Not Applicable
                    @endif
                </div>

            </div>

            <div class="block">
                <div class="block-head">
                    Damage Information
                </div>
                <div class="block-head">
                    Victim Information
                </div>
                <table>
                    <tr>
                        <th class="w-20">Victim</th>
                        <td class="w-80">
                            @if ($data->Victim)
                                {{ Helpers::getInitiatorName($data->Victim) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Medical Treatment ?(Y/N)</th>
                        <td class="w-80">
                            @if ($data->Medical_Treatment)
                                {{ $data->Medical_Treatment }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Victim Position</th>
                        <td class="w-80">
                            @if ($data->Victim_Position)
                                {{ $data->Victim_Position }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Victim Relation To Company</th>
                        <td class="w-80">
                            @if ($data->Victim_Relation_To_Company)
                                {{ $data->Victim_Relation_To_Company }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Hospitalization</th>
                        <td class="w-80">
                            @if ($data->Hospitalization)
                                {{ $data->Hospitalization }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Hospital Name</th>
                        <td class="w-80">
                            @if ($data->Hospital_Name)
                                {{ $data->Hospital_Name }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Date Of Treatment</th>
                        <td class="w-80">
                            @if ($data->Date_Of_Treatment)
                                {{ Helpers::getdateFormat($data->Date_Of_Treatment) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Victim Treated By</th>
                        <td class="w-80">
                            @if ($data->Victim_Treated_By)
                                {{ $data->Victim_Treated_By }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>
                <label class="head-number" for="Medical Treatment Description">Medical Treatment Description</label>
                <div class="div-data">
                    @if ($data->Medical_Treatment_Description)
                        {{ $data->Medical_Treatment_Description }}
                    @else
                        Not Applicable
                    @endif
                </div>

                <div class="block-head">
                    Physical Damage
                </div>
                <table>
                    <tr>
                        <th class="w-20">Injury Type</th>
                        <td class="w-80">
                            @if ($data->Injury_Type)
                                {{ $data->Injury_Type }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Number Of Injuries</th>
                        <td class="w-80">
                            @if ($data->Number_Of_Injuries)
                                {{ $data->Number_Of_Injuries }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Type Of Injuries</th>
                        <td class="w-80">
                            @if ($data->Type_Of_Injuries)
                                {{ $data->Type_Of_Injuries }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Injured Body Parts</th>
                        <td class="w-80">
                            @if ($data->Injured_Body_Parts)
                                {{ $data->Injured_Body_Parts }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Type Of Illness</th>
                        <td class="w-80">
                            @if ($data->Type_Of_Illness)
                                {{ $data->Type_Of_Illness }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Permanent Disability?</th>
                        <td class="w-80">
                            @if ($data->Permanent_Disability)
                                {{ $data->Permanent_Disability }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>
                <div class="block-head">
                    Damage Information
                </div>
                <table>
                    <tr>
                        <th class="w-20">Damage Category</th>
                        <td class="w-80">
                            @if ($data->Damage_Category)
                                {{ $data->Damage_Category }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>

                <label class="head-number" for="Related Equipment">Related Equipment</label>
                <div class="div-data">
                    @if ($data->Related_Equipment)
                        {{ $data->Related_Equipment }}
                    @else
                        Not Applicable
                    @endif
                </div>

                <table>
                    <tr>
                        <th class="w-20">Estimated Amount Of Damage</th>
                        <td class="w-80">
                            @if ($data->Estimated_Amount_Of_Damage)
                                {{ $data->Estimated_Amount_Of_Damage }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Currency</th>
                        <td class="w-80">
                            @if ($data->Currency)
                                {{ $data->Currency }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Insurance Company Involved?</th>
                        <td class="w-80">
                            @if ($data->Insurance_Company_Involved)
                                {{ $data->Insurance_Company_Involved }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Denied By Insurance Company</th>
                        <td class="w-80">
                            @if ($data->Denied_By_Insurance_Company)
                                {{ $data->Denied_By_Insurance_Company }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>
                <label class="head-number" for="Damage Details">Damage Details</label>
                <div class="div-data">
                    @if ($data->Damage_Details)
                        {{ $data->Damage_Details }}
                    @else
                        Not Applicable
                    @endif
                </div>

            </div>

            <div class="block">
                <div class="block-head">
                    Investigation Summary
                </div>
                <table>
                    <tr>
                        <th class="w-20">Actual Amount Of Damage</th>
                        <td class="w-80">
                            @if ($data->Actual_Amount_Of_Damage)
                                {{ $data->Actual_Amount_Of_Damage }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Currency</th>
                        <td class="w-80">
                            @if ($data->Currency2)
                                {{ $data->Currency2 }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                </table>
                <label class="head-number" for="Investigation Summary">Investigation Summary</label>
                <div class="div-data">
                    @if ($data->Investigation_Summary)
                        {{ $data->Investigation_Summary }}
                    @else
                        Not Applicable
                    @endif
                </div>

                <label class="head-number" for="Conclusion">Conclusion</label>
                <div class="div-data">
                    @if ($data->Conclusion)
                        {{ $data->Conclusion }}
                    @else
                        Not Applicable
                    @endif
                </div>
            </div>

            <div class="block">
                <div class="block-head">
                    Root Cause And Risk Analysis
                </div>
                <label class="head-number" for="Root Cause Methodology">Root Cause Methodology</label>
                <div class="div-data">
                    @if ($data->root_cause_methodology)
                        {{ str_replace(',', ', ', $data->root_cause_methodology) }}
                    @else
                        Not Applicable
                    @endif
                </div>

                <label class="head-number" for="Root Cause Description">Root Cause Description</label>
                <div class="div-data">
                    @if ($data->Root_Cause_Description)
                        {{ $data->Root_Cause_Description }}
                    @else
                        Not Applicable
                    @endif
                </div>

                <div class="block-head">
                    Risk Factors
                </div>
                <table>
                    <tr>
                        <th class="w-20">Safety Impact Probability</th>
                        <td class="w-80">
                            @if ($data->Safety_Impact_Probability)
                                {{ $data->Safety_Impact_Probability }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Safety Impact Severity</th>
                        <td class="w-80">
                            @if ($data->Safety_Impact_Severity)
                                {{ $data->Safety_Impact_Severity }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Legal Impact Probability</th>
                        <td class="w-80">
                            @if ($data->Legal_Impact_Probability)
                                {{ $data->Legal_Impact_Probability }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Legal Impact Severity</th>
                        <td class="w-80">
                            @if ($data->Legal_Impact_Severity)
                                {{ $data->Legal_Impact_Severity }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Business Impact Probability</th>
                        <td class="w-80">
                            @if ($data->Business_Impact_Probability)
                                {{ $data->Business_Impact_Probability }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Business Impact Severity</th>
                        <td class="w-80">
                            @if ($data->Business_Impact_Severity)
                                {{ $data->Business_Impact_Severity }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Revenue Impact Probability</th>
                        <td class="w-80">
                            @if ($data->Revenue_Impact_Probability)
                                {{ $data->Revenue_Impact_Probability }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Revenue Impact Severity</th>
                        <td class="w-80">
                            @if ($data->Revenue_Impact_Severity)
                                {{ $data->Revenue_Impact_Severity }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Brand Impact Probability</th>
                        <td class="w-80">
                            @if ($data->Brand_Impact_Probability)
                                {{ $data->Brand_Impact_Probability }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Brand Impact Severity</th>
                        <td class="w-80">
                            @if ($data->Brand_Impact_Severity)
                                {{ $data->Brand_Impact_Severity }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>
                <div class="block-head">
                    Calculated Risk And Further Actions
                </div>
                <table>
                    <tr>
                        <th class="w-20">Safety Impact Risk</th>
                        <td class="w-80">
                            @if ($data->Safety_Impact_Risk)
                                {{ $data->Safety_Impact_Risk }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Legal Impact Risk</th>
                        <td class="w-80">
                            @if ($data->Legal_Impact_Risk)
                                {{ $data->Legal_Impact_Risk }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Business Impact Risk</th>
                        <td class="w-80">
                            @if ($data->Business_Impact_Risk)
                                {{ $data->Business_Impact_Risk }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Revenue Impact Risk</th>
                        <td class="w-80">
                            @if ($data->Revenue_Impact_Risk)
                                {{ $data->Revenue_Impact_Risk }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Brand Impact Risk</th>
                        <td class="w-80">
                            @if ($data->Brand_Impact_Risk)
                                {{ $data->Brand_Impact_Risk }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>

                <div class="block-head">
                    General Risk Information
                </div>
                <table>
                    <tr>
                        <th class="w-20">Impact</th>
                        <td class="w-80">
                            @if ($data->Impact)
                                {{ $data->Impact }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>
                <label class="head-number" for="Impact Analysis">Impact Analysis</label>
                <div class="div-data">
                    @if ($data->Impact_Analysis)
                        {{ $data->Impact_Analysis }}
                    @else
                        Not Applicable
                    @endif
                </div>

                <label class="head-number" for="Recommended Actions">Recommended Actions</label>
                <div class="div-data">
                    @if ($data->Recommended_Actions)
                        {{ $data->Recommended_Actions }}
                    @else
                        Not Applicable
                    @endif
                </div>

                <label class="head-number" for="Comments">Comments</label>
                <div class="div-data">
                    @if ($data->Comments2)
                        {{ $data->Comments2 }}
                    @else
                        Not Applicable
                    @endif
                </div>

                <table>
                    <tr>
                        <th class="w-20">Direct Cause</th>
                        <td class="w-80">
                            @if ($data->Direct_Cause)
                                {{ $data->Direct_Cause }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Safeguarding Measure Taken</th>
                        <td class="w-80">
                            @if ($data->Safeguarding_Measure_Taken2)
                                {{ $data->Safeguarding_Measure_Taken2 }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>

                <div class="block-head">
                    Risk Analysis
                </div>
                <table>
                    <tr>
                        <th class="w-20">Severity Rate</th>
                        <td class="w-80">
                            @if ($data->severity_rate)
                                {{ $data->severity_rate }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Occurrence</th>
                        <td class="w-80">
                            @if ($data->occurrence)
                                {{ $data->occurrence }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Detection</th>
                        <td class="w-80">
                            @if ($data->detection)
                                {{ $data->detection }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">RPN</th>
                        <td class="w-80">
                            @if ($data->rpn)
                                {{ $data->rpn }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>
                <label class="head-number" for="Risk Analysis">Risk Analysis</label>
                <div class="div-data">
                    @if ($data->Risk_Analysis)
                        {{ $data->Risk_Analysis }}
                    @else
                        Not Applicable
                    @endif
                </div>

                <table>
                    <tr>
                        <th class="w-20">Critically</th>
                        <td class="w-80">
                            @if ($data->Critically)
                                {{ $data->Critically }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Inform Local Authority?</th>
                        <td class="w-80">
                            @if ($data->Inform_Local_Authority)
                                {{ $data->Inform_Local_Authority }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Authority Type</th>
                        <td class="w-80">
                            @if ($data->Authority_Type)
                                {{ $data->Authority_Type }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Authority Notified</th>
                        <td class="w-80">
                            @if ($data->Authority_Notified)
                                {{ $data->Authority_Notified }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>
                <label class="head-number" for="Other Authority">Other Authority</label>
                <div class="div-data">
                    @if ($data->Other_Authority)
                        {{ $data->Other_Authority }}
                    @else
                        Not Applicable
                    @endif
                </div>
            </div>


            <!-- ------ ------CC - 6----------------- -->
            <div class="block">
                <div class="block-head">
                    Employee and Personnel Information
                </div>
                <table>
                    <tr>
                        <th class="w-20">Employee ID</th>
                        <td class="w-80">
                            @if ($data->employee_id)
                                {{ $data->employee_id }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Employee Name</th>
                        <td class="w-80">
                            @if ($data->employee_name)
                                {{ $data->employee_name }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Designation</th>
                        <td class="w-80">
                            @if ($data->designation)
                                {{ $data->designation }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Department</th>
                        <td class="w-80">
                            @if ($data->department2)
                                {{ $data->department2 }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Phone Number</th>
                        <td class="w-80">
                            @if ($data->phone_number)
                                {{ $data->phone_number }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Email</th>
                        <td class="w-80">
                            @if ($data->email)
                                {{ $data->email }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Date of Joining</th>
                        <td class="w-80">
                            @if ($data->date_of_joining)
                                {{ Helpers::getdateFormat($data->date_of_joining) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Safety Training Records</th>
                        <td class="w-80">
                            @if ($data->safety_training_records)
                                {{ $data->safety_training_records }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Medical History</th>
                        <td class="w-80">
                            @if ($data->medical_history)
                                {{ $data->medical_history }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Personal Protective Equipment (PPE) Compliance</th>
                        <td class="w-80">
                            @if ($data->personal_protective_equipment_compliance)
                                {{ $data->personal_protective_equipment_compliance }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Emergency Contacts</th>
                        <td class="w-80">
                            @if ($data->emergency_contacts)
                                {{ $data->emergency_contacts }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
            <!-- ----- -------CC - 7----------------- -->
            <div class="block">
                <div class="block-head">
                    Regulatory Compliance Data
                </div>
                <table>
                    <tr>
                        <th class="w-20">Compliance Standards/Regulations</th>
                        <td class="w-80">
                            @if ($data->compliance_standards_regulations)
                                {{ $data->compliance_standards_regulations }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Regulatory Authority/Agency</th>
                        <td class="w-80">
                            @if ($data->regulatory_authority_agency)
                                {{ $data->regulatory_authority_agency }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Inspection Dates and Reports</th>
                        <td class="w-80">
                            @if ($data->inspection_dates_and_reports)
                                {{ Helpers::getdateFormat($data->inspection_dates_and_reports) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Audit/Inspection Results</th>
                        <td class="w-80">
                            @if ($data->audit_inspection_results)
                                {{ $data->audit_inspection_results }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Non-compliance Issues</th>
                        <td class="w-80">
                            @if ($data->non_compliance_issues)
                                {{ $data->non_compliance_issues }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Environmental Permits</th>
                        <td class="w-80">
                            @if ($data->environmental_permits)
                                {{ $data->environmental_permits }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Workplace Safety Certifications</th>
                        <td class="w-80">
                            @if ($data->workplace_safety_certifications)
                                {{ $data->workplace_safety_certifications }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
            <!-- --- ---------CC - 8---------------------- -->
            <div class="block">
                <div class="block-head">
                    Incident and Accident Reporting
                </div>
                <table>
                    <tr>
                        <th class="w-20">Incident ID</th>
                        <td class="w-80">
                            @if ($data->incident_id)
                                {{ $data->incident_id }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Date of Incident</th>
                        <td class="w-80">
                            @if ($data->date_of_incident)
                                {{ Helpers::getdateFormat($data->date_of_incident) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Time of Incident</th>
                        <td class="w-80">
                            @if ($data->time_of_incident)
                                {{ $data->time_of_incident }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Type of Incident</th>
                        <td class="w-80">
                            @if ($data->type_of_incident)
                                {{ $data->type_of_incident }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Incident Severity</th>
                        <td class="w-80">
                            @if ($data->incident_severity)
                                {{ $data->incident_severity }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Location of Incident</th>
                        <td class="w-80">
                            @if ($data->location_of_incident)
                                {{ $data->location_of_incident }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Affected Personnel</th>
                        <td class="w-80">
                            @if ($data->affected_personnel)
                                {{ $data->affected_personnel }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Root Cause Analysis</th>
                        <td class="w-80">
                            @if ($data->root_cause_analysis)
                                {{ $data->root_cause_analysis }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Corrective and Preventive Actions (CAPA)</th>
                        <td class="w-80">
                            @if ($data->corrective_and_preventive_actions)
                                {{ $data->corrective_and_preventive_actions }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Investigation Reports</th>
                        <td class="w-80">
                            @if ($data->investigation_reports)
                                {{ $data->investigation_reports }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Injury Severity and Report</th>
                        <td class="w-80">
                            @if ($data->injury_severity_and_report)
                                {{ $data->injury_severity_and_report }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Incident Resolution Status</th>
                        <td class="w-80">
                            @if ($data->incident_resolution_status)
                                {{ $data->incident_resolution_status }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
            <!-- ----- -------CC - 9------------------------ -->
            <div class="block">
                <div class="block-head">
                    Chemical and Hazardous Materials Management
                </div>
                <table>
                    <!-- ----- add grid -->
                </table>
            </div>
            <!-- ---- ------CC - 10------------------------- -->
            <div class="block">
                <div class="block-head">
                    Workplace Safety and Environment Monitoring
                </div>
                <table>
                    <tr>
                        <th class="w-20">Workplace Safety Audits</th>
                        <td class="w-80">
                            @if ($data->workplace_safety_audits)
                                {{ $data->workplace_safety_audits }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Hazardous Area Identification</th>
                        <td class="w-80">
                            @if ($data->hazardous_area_identification)
                                {{ $data->hazardous_area_identification }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Ventilation Systems Monitoring</th>
                        <td class="w-80">
                            @if ($data->ventilation_systems_monitoring)
                                {{ $data->ventilation_systems_monitoring }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Noise Levels Monitoring</th>
                        <td class="w-80">
                            @if ($data->noise_levels_monitoring)
                                {{ $data->noise_levels_monitoring }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Lighting and Temperature Monitoring</th>
                        <td class="w-80">
                            @if ($data->lighting_and_temperature_monitoring)
                                {{ $data->lighting_and_temperature_monitoring }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Personal Monitoring (Health and Safety Data)</th>
                        <td class="w-80">
                            @if ($data->personal_monitoring)
                                {{ $data->personal_monitoring }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Ergonomics Data</th>
                        <td class="w-80">
                            @if ($data->ergonomics_data)
                                {{ $data->ergonomics_data }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
            <!-- ---- ------CC - 11------------------------ -->
            <div class="block">
                <div class="block-head">
                    Health and Occupational Safety
                </div>
                <table>
                    <tr>
                        <th class="w-20">Employee Health Records</th>
                        <td class="w-80">
                            @if ($data->Employee_Health_Records)
                                {{ $data->Employee_Health_Records }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Occupational Exposure Limits</th>
                        <td class="w-80">
                            @if ($data->Occupational_Exposure_Limits)
                                {{ $data->Occupational_Exposure_Limits }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Vaccination Records</th>
                        <td class="w-80">
                            @if ($data->Vaccination_Records)
                                {{ $data->Vaccination_Records }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Pre-employment and Routine Health Screenings</th>
                        <td class="w-80">
                            @if ($data->Pre_employment_and_Routine_Health_Screenings)
                                {{ $data->Pre_employment_and_Routine_Health_Screenings }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Workplace Injury and Illness Reporting</th>
                        <td class="w-80">
                            @if ($data->Workplace_Injury_and_Illness_Reporting)
                                {{ $data->Workplace_Injury_and_Illness_Reporting }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Absenteeism Data</th>
                        <td class="w-80">
                            @if ($data->Absenteeism_Data)
                                {{ $data->Absenteeism_Data }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Safety Drills and Training Records</th>
                        <td class="w-80">
                            @if ($data->Safety_Drills_and_Training_Records)
                                {{ $data->Safety_Drills_and_Training_Records }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">First Aid and Emergency Response Records</th>
                        <td class="w-80">
                            @if ($data->First_Aid_and_Emergency_Response_Records)
                                {{ $data->First_Aid_and_Emergency_Response_Records }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Safety Drills and Training Records</th>
                        <td class="w-80">
                            @if ($data->Safety_Drills_and_Training_Records)
                                {{ $data->Safety_Drills_and_Training_Records }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">First Aid and Emergency Response Records</th>
                        <td class="w-80">
                            @if ($data->First_Aid_and_Emergency_Response_Records)
                                {{ $data->First_Aid_and_Emergency_Response_Records }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
            <!-- ---- --------CC- 12--------- -->
            <div class="block">
                <div class="block-head">
                    Emergency Preparedness and Response
                </div>
                <table>
                    <tr>
                        <th class="w-20">Emergency Plan</th>
                        <td class="w-80">
                            @if ($data->Emergency_Plan)
                                {{ $data->Emergency_Plan }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Emergency Contacts</th>
                        <td class="w-80">
                            @if ($data->Emergency_Contacts2)
                                {{ $data->Emergency_Contacts2 }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Emergency Equipment</th>
                        <td class="w-80">
                            @if ($data->Emergency_Equipment)
                                {{ $data->Emergency_Equipment }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Incident Simulation Drills</th>
                        <td class="w-80">
                            @if ($data->Incident_Simulation_Drills)
                                {{ $data->Incident_Simulation_Drills }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Response Time Metrics</th>
                        <td class="w-80">
                            @if ($data->Response_Time_Metrics)
                                {{ $data->Response_Time_Metrics }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Evacuation Routes and Assembly Points</th>
                        <td class="w-80">
                            @if ($data->Evacuation_Routes_and_Assembly_Points)
                                {{ $data->Evacuation_Routes_and_Assembly_Points }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
            <!-- ----- --CC - 15------------- -->
            <div class="block">
                <div class="block-head">
                    Environmental Impact Data
                </div>
                <table>
                    <tr>
                        <th class="w-20">Energy Consumption</th>
                        <td class="w-80">
                            @if ($data->Energy_Consumption)
                                {{ $data->Energy_Consumption }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Greenhouse Gas Emissions</th>
                        <td class="w-80">
                            @if ($data->Greenhouse_Gas_Emissions)
                                {{ $data->Greenhouse_Gas_Emissions }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Wastewater Discharge</th>
                        <td class="w-80">
                            @if ($data->Wastewater_Discharge)
                                {{ $data->Wastewater_Discharge }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Air Quality Monitoring</th>
                        <td class="w-80">
                            @if ($data->Air_Quality_Monitoring)
                                {{ $data->Air_Quality_Monitoring }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Environmental Sustainability Projects</th>
                        <td class="w-80">
                            @if ($data->Environmental_Sustainability_Projects)
                                {{ $data->Environmental_Sustainability_Projects }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>
                <div>
                    <!-- ---- ----CC- 16-------- -->
                    <div class="block">
                        <div class="block-head">
                            Environmental Impact Data
                        </div>
                        <table>
                            <tr>
                                <th class="w-20">Energy Type</th>
                                <td class="w-80">
                                    @if ($data->enargy_type)
                                        {{ $data->enargy_type }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                                <th class="w-20">Energy Source</th>
                                <td class="w-80">
                                    @if ($data->enargy_source)
                                        {{ $data->enargy_source }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <th class="w-20">Energy Usage (kWh)</th>
                                <td class="w-80">
                                    @if ($data->enargy_type)
                                        {{ $data->enargy_type }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                                <th class="w-20">Energy Intensity</th>
                                <td class="w-80">
                                    @if ($data->energy_intensity)
                                        {{ $data->energy_intensity }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <th class="w-20">Peak Demand (kW)</th>
                                <td class="w-80">
                                    @if ($data->peak_demand)
                                        {{ $data->peak_demand }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                                <th class="w-20">Energy Efficiency</th>
                                <td class="w-80">
                                    @if ($data->energy_efficiency)
                                        {{ $data->energy_efficiency }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                    <!-- ---- ----CC - 17-------- -->
                    <div class="block">
                        <div class="block-head">
                            Carbon Emissions (Greenhouse Gases)
                        </div>
                        <table>
                            <tr>
                                <th class="w-20">CO2 Emissions (kg/tons)</th>
                                <td class="w-80">
                                    @if ($data->co_emissions)
                                        {{ $data->co_emissions }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                                <th class="w-20">Greenhouse Gas Emissions (GHG)</th>
                                <td class="w-80">
                                    @if ($data->greenhouse_ges_emmission)
                                        {{ $data->greenhouse_ges_emmission }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <th class="w-20">Scope 1 Emissions</th>
                                <td class="w-80">
                                    @if ($data->scope_one_emission)
                                        {{ $data->scope_one_emission }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                                <th class="w-20">Scope 2 Emissions</th>
                                <td class="w-80">
                                    @if ($data->scope_two_emission)
                                        {{ $data->scope_two_emission }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <th class="w-20">Scope 3 Emissions</th>
                                <td class="w-80">
                                    @if ($data->scope_three_emission)
                                        {{ $data->scope_three_emission }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                                <th class="w-20">Carbon Intensity</th>
                                <td class="w-80">
                                    @if ($data->carbon_intensity)
                                        {{ $data->carbon_intensity }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
                        </table>
                        <div>
                            <!-- ----- ---CC - 18 ------------- -->
                            <div class="block">
                                <div class="block-head">
                                    Water Usage
                                </div>
                                <table>
                                    <tr>
                                        <th class="w-20">Water Consumption (m³ or liters)</th>
                                        <td class="w-80">
                                            @if ($data->water_consumption)
                                                {{ $data->water_consumption }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </td>
                                        <th class="w-20">Water Source</th>
                                        <td class="w-80">
                                            @if ($data->water_source)
                                                {{ $data->water_source }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </td>
                                    </tr>

                                    <tr>
                                        <th class="w-20">Water Efficiency</th>
                                        <td class="w-80">
                                            @if ($data->water_effeciency)
                                                {{ $data->water_effeciency }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </td>
                                        <th class="w-20">Water Discharge (m³ or liters)</th>
                                        <td class="w-80">
                                            @if ($data->water_discharge)
                                                {{ $data->water_discharge }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </td>
                                    </tr>

                                    <tr>
                                        <th class="w-20">Waste Water Treatment</th>
                                        <td class="w-80">
                                            @if ($data->waste_water_treatment)
                                                {{ $data->waste_water_treatment }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </td>
                                        <th class="w-20">Rainwater Harvesting</th>
                                        <td class="w-80">
                                            @if ($data->rainwater_harvesting)
                                                {{ $data->rainwater_harvesting }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <!-- --- ---------CC - 19-------- -->
                            <div class="block">
                                <div class="block-head">
                                    Sustainable Procurement
                                </div>
                                <table>
                                    <tr>
                                        <th class="w-20">Sustainable Products Purchased</th>
                                        <td class="w-80">
                                            @if ($data->sustainable_product_purchased)
                                                {{ $data->sustainable_product_purchased }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </td>
                                        <th class="w-20">Sustainable Packaging</th>
                                        <td class="w-80">
                                            @if ($data->sustainable_packaing)
                                                {{ $data->sustainable_packaing }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="w-20">Local Sourcing</th>
                                        <td class="w-80">
                                            @if ($data->local_sourcing)
                                                {{ $data->local_sourcing }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="w-20">Supplier Sustainability</th>
                                        <td class="w-80" colspan="3">
                                            @if ($data->supplier_sustainability)
                                                {{ $data->supplier_sustainability }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </td>
                                    </tr>

                                    <tr>
                                        <th class="w-20">Fair Trade or Certification Labels</th>
                                        <td class="w-80" colspan="3">
                                            @if ($data->fair_trade)
                                                {{ $data->fair_trade }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <!-- --- ------CC - 20-------------- -->
                            <div class="block">
                                <div class="block-head">
                                    Transportation and Logistics
                                </div>
                                <table>
                                    <tr>
                                        <th class="w-20">Fuel Consumption</th>
                                        <td class="w-80">
                                            @if ($data->fuel_consumption)
                                                {{ $data->fuel_consumption }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </td>
                                        <th class="w-20">Vehicle Type</th>
                                        <td class="w-80">
                                            @if ($data->Vehicle_Type1)
                                                {{ $data->Vehicle_Type1 }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </td>
                                    </tr>

                                    <tr>
                                        <th class="w-20">Fleet Emissions</th>
                                        <td class="w-80">
                                            @if ($data->fleet_emissions)
                                                {{ $data->fleet_emissions }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </td>
                                        <th class="w-20">Miles Traveled</th>
                                        <td class="w-80">
                                            @if ($data->miles_traveled)
                                                {{ $data->miles_traveled }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="w-20">Freight and Shipping</th>
                                        <td class="w-80" colspan="3">
                                            @if ($data->freight_and_shipping)
                                                {{ $data->freight_and_shipping }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="w-20">Carbon Offset Programs</th>
                                        <td class="w-80" colspan="3">
                                            @if ($data->carbon_pffset_programs)
                                                {{ $data->carbon_pffset_programs }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <!-- --- ---- CC - 21-------------- -->
                            <div class="block">
                                <div class="block-head">
                                    Biodiversity and Land Use
                                </div>
                                <table>
                                    <tr>
                                        <th class="w-20">Land Area Impacted (m² or hectares)</th>
                                        <td class="w-80">
                                            @if ($data->land_area_impacted)
                                                {{ $data->land_area_impacted }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </td>
                                        <th class="w-20">Protected Areas</th>
                                        <td class="w-80">
                                            @if ($data->protected_areas)
                                                {{ $data->protected_areas }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="w-20">Deforestation</th>
                                        <td class="w-80">
                                            @if ($data->deforestation)
                                                {{ $data->deforestation }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="w-20">Habitat Preservation</th>
                                        <td class="w-80">
                                            @if ($data->habitat_preservation)
                                                {{ $data->habitat_preservation }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="w-20">Biodiversity Initiatives</th>
                                        <td class="w-80">
                                            @if ($data->biodiversity_initiatives)
                                                {{ $data->biodiversity_initiatives }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <!-- --- ------CC - 22--------------- -->
                            <div class="block">
                                <div class="block-head">
                                    Environmental Certifications & Compliance
                                </div>
                                <table>
                                    <tr>
                                        <th class="w-20">Certifications</th>
                                        <td class="w-80">
                                            @if ($data->certifications)
                                                {{ $data->certifications }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </td>
                                        <th class="w-20">Audits</th>
                                        <td class="w-80">
                                            @if ($data->audits)
                                                {{ $data->audits }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="w-20">Regulatory Compliance</th>
                                        <td class="w-80">
                                            @if ($data->regulatory_compliance)
                                                {{ $data->regulatory_compliance }}
                                            @else
                                                Not Applicable
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                                <div>
                                    <!-- --- -------CC - 23----------------- -->
                                    <div class="block">
                                        <div class="block-head">
                                            Environmental Impact and Risk Assessment
                                        </div>
                                        <table>
                                            <tr>
                                                <th class="w-20">Environmental Risk</th>
                                                <td class="w-80">
                                                    @if ($data->enviromental_risk)
                                                        {{ $data->enviromental_risk }}
                                                    @else
                                                        Not Applicable
                                                    @endif
                                                </td>
                                                <th class="w-20">Climate Change Adaptation</th>
                                                <td class="w-80">
                                                    @if ($data->climate_change_adaptation)
                                                        {{ $data->climate_change_adaptation }}
                                                    @else
                                                        Not Applicable
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="w-20">Carbon Footprint</th>
                                                <td class="w-80">
                                                    @if ($data->carbon_footprint)
                                                        {{ $data->carbon_footprint }}
                                                    @else
                                                        Not Applicable
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="w-20">Impact Assessment</th>
                                                <td class="w-80">
                                                    @if ($data->impact_assessment)
                                                        {{ $data->impact_assessment }}
                                                    @else
                                                        Not Applicable
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                        <div>
                                            <!-- --- ------CC - 24------------------ -->
                                            <div class="block">
                                                <div class="block-head">
                                                    Risk Management and Hazard Identification
                                                </div>
                                                <table>
                                                    <tr>
                                                        <th class="w-20">Risk Assessment Data</th>
                                                        <td class="w-80">
                                                            @if ($data->Risk_Assessment_Data)
                                                                {{ $data->Risk_Assessment_Data }}
                                                            @else
                                                                Not Applicable
                                                            @endif
                                                        </td>
                                                        <th class="w-20">Hazard ID Reports</th>
                                                        <td class="w-80">
                                                            @if ($data->hazard_id_reports)
                                                                {{ $data->hazard_id_reports }}
                                                            @else
                                                                Not Applicable
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th class="w-20">Risk Mitigation Plan</th>
                                                        <td class="w-80" colspan="3">
                                                            @if ($data->risk_migration_plan)
                                                                {{ $data->risk_migration_plan }}
                                                            @else
                                                                Not Applicable
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th class="w-20">Corrective Actions</th>
                                                        <td class="w-80" colspan="3">
                                                            @if ($data->corrective_action)
                                                                {{ $data->corrective_action }}
                                                            @else
                                                                Not Applicable
                                                            @endif
                                                        </td>
                                                    </tr>

                                                </table>
                                                <div>
                                                    <!-- --- -----CC - 25------------------- -->
                                                    <div class="block">
                                                        <div class="block-head">
                                                            Audit and Inspection Records
                                                        </div>
                                                        <table>
                                                            <tr>
                                                                <th class="w-20">Audit ID</th>
                                                                <td class="w-80">
                                                                    @if ($data->audit_id)
                                                                        {{ $data->audit_id }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                                <th class="w-20">Audit Type</th>
                                                                <td class="w-80">
                                                                    @if ($data->Audit_Type)
                                                                        {{ $data->Audit_Type }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <th class="w-20">Audit Date</th>
                                                                <td class="w-80">
                                                                    @if ($data->audit_date)
                                                                        {{ Helpers::getdateFormat($data->audit_date) }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                                <th class="w-20">Audit Scope</th>
                                                                <td class="w-80">
                                                                    @if ($data->audit_scope)
                                                                        {{ $data->audit_scope }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <th class="w-20">Findings and Observations</th>
                                                                <td class="w-80" colspan="3">
                                                                    @if ($data->finding_and_observation)
                                                                        {{ $data->finding_and_observation }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th class="w-20">Corrective Action Plans</th>
                                                                <td class="w-80" colspan="3">
                                                                    @if ($data->corrective_action_plans)
                                                                        {{ $data->corrective_action_plans }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <th class="w-20">Follow-up Audit Results</th>
                                                                <td class="w-80" colspan="3">
                                                                    @if ($data->follow_up_audit_result)
                                                                        {{ $data->follow_up_audit_result }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <!-- ---- --CC - 26---------------------- -->
                                                    <div class="block">
                                                        <div class="block-head">
                                                            Sustainability and Corporate Social Responsibility (CSR)
                                                        </div>
                                                        <table>
                                                            <tr>
                                                                <th class="w-20">Sustainability Initiatives</th>
                                                                <td class="w-80">
                                                                    @if ($data->sustainability_initiatives)
                                                                        {{ $data->sustainability_initiatives }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                                <th class="w-20">CSR Activities</th>
                                                                <td class="w-80">
                                                                    @if ($data->csr_activities)
                                                                        {{ $data->csr_activities }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th class="w-20">Sustainability Reporting</th>
                                                                <td class="w-80" colspan="3">
                                                                    @if ($data->sustainability_reporting)
                                                                        {{ $data->sustainability_reporting }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <th class="w-20">Public Relations/Community
                                                                    Engagement Reports</th>
                                                                <td class="w-80" colspan="3">
                                                                    @if ($data->public_relation_report)
                                                                        {{ $data->public_relation_report }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <!-- ---- ----CC - 27----------------- -->
                                                    <div class="block">
                                                        <div class="block-head">
                                                            Analytics and Reporting
                                                        </div>
                                                        <table>
                                                            <tr>
                                                                <th class="w-20">Dashboards</th>
                                                                <td class="w-80">
                                                                    @if ($data->Dashboards)
                                                                        {{ $data->Dashboards }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                                <th class="w-20">Key Performance Indicators (KPIs)
                                                                </th>
                                                                <td class="w-80">
                                                                    @if ($data->key_performance_indicators)
                                                                        {{ $data->key_performance_indicators }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <th class="w-20">Trend Analysis</th>
                                                                <td class="w-80">
                                                                    @if ($data->trend_analysis)
                                                                        {{ $data->trend_analysis }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                                <th class="w-20">Data Export Functionality</th>
                                                                <td class="w-80">
                                                                    @if ($data->data_export_functionality)
                                                                        {{ $data->data_export_functionality }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <th class="w-20">Monthly/Quarterly/Annual Reports
                                                                </th>
                                                                <td class="w-80" colspan="3">
                                                                    @if ($data->monthly_annual_reports)
                                                                        {{ $data->monthly_annual_reports }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <!-- ------ ---CC - 28------------- -->
                                                    <div class="block">
                                                        <div class="block-head">
                                                            Sustainability Goals and Metrics
                                                        </div>
                                                        <table>
                                                            <tr>
                                                                <th class="w-20">KPIs (Key Performance Indicators)
                                                                </th>
                                                                <td class="w-80">
                                                                    @if ($data->KPIs)
                                                                        {{ $data->KPIs }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th class="w-20">Sustainability Targets</th>
                                                                <td class="w-80" colspan="3">
                                                                    @if ($data->sustainability_targets)
                                                                        {{ $data->sustainability_targets }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th class="w-20">Progress Towards Goals</th>
                                                                <td class="w-80" colspan="3">
                                                                    @if ($data->progress_towards_goals)
                                                                        {{ $data->progress_towards_goals }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th class="w-20">Goal Name</th>
                                                                <td class="w-80" colspan="3">
                                                                    @if ($data->Goal_Name)
                                                                        {{ $data->Goal_Name }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th class="w-20">Goal Description</th>
                                                                <td class="w-80" colspan="3">
                                                                    @if ($data->Goal_Description)
                                                                        {{ $data->Goal_Description }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <th class="w-20">Responsible Department</th>
                                                                <td class="w-80">
                                                                    @if ($data->Responsible_Department)
                                                                        {{ $data->Responsible_Department }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                                <th class="w-20">Goal Timeframe</th>
                                                                <td class="w-80">
                                                                    @if ($data->Goal_Timeframe)
                                                                        {{ $data->Goal_Timeframe }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <th class="w-20">Region</th>
                                                                <td class="w-80">
                                                                    @if ($data->Region)
                                                                        {{ $data->Region }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <div class="block-head">
                                                            Energy Use
                                                        </div>
                                                        <table>
                                                            <tr>
                                                                <th class="w-20">Energy Source</th>
                                                                <td class="w-80">
                                                                    @if ($data->Energy_Source)
                                                                        {{ $data->Energy_Source }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                                <th class="w-20">Energy Consumption (MWh)</th>
                                                                <td class="w-80">
                                                                    @if ($data->Energy_Consumption2)
                                                                        {{ $data->Energy_Consumption2 }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <th class="w-20">Energy Efficiency Target (%)</th>
                                                                <td class="w-80">
                                                                    @if ($data->Energy_Efficiency_Target)
                                                                        {{ $data->Energy_Efficiency_Target }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                                <th class="w-20">Renewable Energy Usage Target (%)
                                                                </th>
                                                                <td class="w-80">
                                                                    @if ($data->Renewable_Energy_Usage_Target)
                                                                        {{ $data->Renewable_Energy_Usage_Target }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        </table>


                                                        <div class="block-head">
                                                            Carbon Emissions
                                                        </div>
                                                        <table>
                                                            <tr>
                                                                <th class="w-20">Emission Source</th>
                                                                <td class="w-80">
                                                                    @if ($data->Emission_Source)
                                                                        {{ $data->Emission_Source }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                                <th class="w-20">Carbon Footprint (Metric Tons CO2e)
                                                                </th>
                                                                <td class="w-80">
                                                                    @if ($data->Carbon_Footprint2)
                                                                        {{ $data->Carbon_Footprint2 }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <th class="w-20">Reduction Target (%)</th>
                                                                <td class="w-80">
                                                                    @if ($data->Reduction_Target)
                                                                        {{ $data->Reduction_Target }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                                <th class="w-20">Offset Mechanisms</th>
                                                                <td class="w-80">
                                                                    @if ($data->Offset_Mechanisms)
                                                                        {{ $data->Offset_Mechanisms }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        </table>

                                                        <div class="block-head">
                                                            Water Conservation
                                                        </div>
                                                        <table>
                                                            <tr>
                                                                <th class="w-20">Water Source</th>
                                                                <td class="w-80">
                                                                    @if ($data->Water_Source2)
                                                                        {{ $data->Water_Source2 }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                                <th class="w-20">Water Consumption (m³)</th>
                                                                <td class="w-80">
                                                                    @if ($data->Water_Consumption2)
                                                                        {{ $data->Water_Consumption2 }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <th class="w-20">Water Efficiency Target (%)</th>
                                                                <td class="w-80">
                                                                    @if ($data->Water_Efficiency_Target)
                                                                        {{ $data->Water_Efficiency_Target }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                                <th class="w-20">Recycled Water Usage Target (%)</th>
                                                                <td class="w-80">
                                                                    @if ($data->Recycled_Water_Usage_Target)
                                                                        {{ $data->Recycled_Water_Usage_Target }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        </table>

                                                        <div class="block-head">
                                                            Waste Management
                                                        </div>
                                                        <table>
                                                            <tr>
                                                                <th class="w-20">Waste Type</th>
                                                                <td class="w-80">
                                                                    @if ($data->Waste_Type)
                                                                        {{ $data->Waste_Type }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                                <th class="w-20">Waste Quantity (kg)</th>
                                                                <td class="w-80">
                                                                    @if ($data->Waste_Quantity)
                                                                        {{ $data->Waste_Quantity }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <th class="w-20">Recycling Rate Target (%)</th>
                                                                <td class="w-80">
                                                                    @if ($data->Recycling_Rate_Target)
                                                                        {{ $data->Recycling_Rate_Target }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                                <th class="w-20">Disposal Methods</th>
                                                                <td class="w-80">
                                                                    @if ($data->Disposal_Methods)
                                                                        {{ $data->Disposal_Methods }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        </table>


                                                        <div class="block-head">
                                                            Biodiversity
                                                        </div>
                                                        <table>
                                                            <tr>
                                                                <th class="w-20">Protected Areas Covered (ha)</th>
                                                                <td class="w-80">
                                                                    @if ($data->Protected_Areas_Covered)
                                                                        {{ $data->Protected_Areas_Covered }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                                <th class="w-20">Species Monitored</th>
                                                                <td class="w-80">
                                                                    @if ($data->Species_Monitored)
                                                                        {{ $data->Species_Monitored }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <th class="w-20">Habitat Restoration Target (ha)</th>
                                                                <td class="w-80">
                                                                    @if ($data->Habitat_Restoration_Target)
                                                                        {{ $data->Habitat_Restoration_Target }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                                <th class="w-20">Biodiversity Index Score</th>
                                                                <td class="w-80">
                                                                    @if ($data->Biodiversity_Index_Score)
                                                                        {{ $data->Biodiversity_Index_Score }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        </table>

                                                        <div class="block-head">
                                                            Sustainable Procurement
                                                        </div>
                                                        <table>
                                                            <tr>
                                                                <th class="w-20">Supplier Compliance</th>
                                                                <td class="w-80">
                                                                    @if ($data->Supplier_Compliance)
                                                                        {{ $data->Supplier_Compliance }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                                <th class="w-20">Percentage of Sustainable Products
                                                                    (%)</th>
                                                                <td class="w-80">
                                                                    @if ($data->Percentage_of_Sustainable_Products)
                                                                        {{ $data->Percentage_of_Sustainable_Products }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <th class="w-20">Local Sourcing Target (%)</th>
                                                                <td class="w-80">
                                                                    @if ($data->Local_Sourcing_Target)
                                                                        {{ $data->Local_Sourcing_Target }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        </table>


                                                        <div class="block-head">
                                                            Circular Economy Metrics
                                                        </div>
                                                        <table>
                                                            <tr>
                                                                <th class="w-20">Product Life Extension Target (%)
                                                                </th>
                                                                <td class="w-80">
                                                                    @if ($data->Product_Life_Extension_Target)
                                                                        {{ $data->Product_Life_Extension_Target }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                                <th class="w-20">Material Reusability (%)</th>
                                                                <td class="w-80">
                                                                    @if ($data->Material_Reusability)
                                                                        {{ $data->Material_Reusability }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <th class="w-20">Recycled Material Usage (%)</th>
                                                                <td class="w-80">
                                                                    @if ($data->Recycled_Material_Usage)
                                                                        {{ $data->Recycled_Material_Usage }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        </table>


                                                        <div class="block-head">
                                                            Policy Alignment
                                                        </div>
                                                        <table>
                                                            <tr>
                                                                <th class="w-20">SDG Alignment</th>
                                                                <td class="w-80">
                                                                    @if ($data->SDG_Alignment)
                                                                        {{ $data->SDG_Alignment }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                                <th class="w-20">Compliance Status</th>
                                                                <td class="w-80">
                                                                    @if ($data->Compliance_Status)
                                                                        {{ $data->Compliance_Status }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        </table>

                                                        <div class="block-head">
                                                            Reporting and Monitoring
                                                        </div>
                                                        <table>
                                                            <tr>
                                                                <th class="w-20">Progress Measurement Frequency</th>
                                                                <td class="w-80">
                                                                    @if ($data->Progress_Measurement_Frequency)
                                                                        {{ $data->Progress_Measurement_Frequency }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                                <th class="w-20">Recycled Material Usage (%)</th>
                                                                <td class="w-80">
                                                                    @if ($data->Recycled_Material_Usage1)
                                                                        {{ $data->Recycled_Material_Usage1 }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <th class="w-20">Current Progress (%)</th>
                                                                <td class="w-80">
                                                                    @if ($data->Current_Progress)
                                                                        {{ $data->Current_Progress }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        </table>

                                                    </div>
                                                    <!-- --- -- CC - 29------------------ -->
                                                    <div class="block">
                                                        <div class="block-head">
                                                            Employee Engagement and Education
                                                        </div>
                                                        <table>
                                                            <tr>
                                                                <th class="w-20">Training Programs</th>
                                                                <td class="w-80">
                                                                    @if ($data->training_programs)
                                                                        {{ $data->training_programs }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                                <th class="w-20">Employee Involvement</th>
                                                                <td class="w-80">
                                                                    @if ($data->employee_involcement)
                                                                        {{ $data->employee_involcement }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <th class="w-20">Sustainability Awareness</th>
                                                                <td class="w-80" colspan="3">
                                                                    @if ($data->sustainability_awareness)
                                                                        {{ $data->sustainability_awareness }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <!-- ------ ----CC - 30---------------------- -->
                                                    <div class="block">
                                                        <div class="block-head">
                                                            Community Engagement and Social Responsibility
                                                        </div>
                                                        <table>
                                                            <tr>
                                                                <th class="w-20">Community Projects</th>
                                                                <td class="w-80">
                                                                    @if ($data->community_project)
                                                                        {{ $data->community_project }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                                <th class="w-20">Partnerships</th>
                                                                <td class="w-80">
                                                                    @if ($data->Partnerships)
                                                                        {{ $data->Partnerships }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <th class="w-20">Social Impact</th>
                                                                <td class="w-80">
                                                                    @if ($data->social_impact)
                                                                        {{ $data->social_impact }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <!-- ----- ------------------------------ -->


                                                    <div class="block">
                                                        <div class="block-head">
                                                            Activity Log
                                                        </div>
                                                        <table>
                                                            <tr>
                                                                <th class="w-30">Submit By
                                                                </th>
                                                                <td class="w-30">
                                                                    @if ($data->Submit_By)
                                                                        {{ $data->Submit_By }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                                <th class="w-20">
                                                                    Submit On</th>
                                                                <td class="w-30">
                                                                    @if ($data->Submit_On)
                                                                        {{ $data->Submit_On }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                                <th class="w-20">
                                                                    Submit Comment</th>
                                                                <td class="w-30">
                                                                    @if ($data->Submit_Comment)
                                                                        {{ $data->Submit_Comment }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th class="w-20">Cancel By
                                                                </th>
                                                                <td class="w-30">
                                                                    @if ($data->Cancelled_By)
                                                                        {{ $data->Cancelled_By }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                                <th class="w-20">
                                                                    Cancel On</th>
                                                                <td class="w-30">
                                                                    @if ($data->Cancelled_On)
                                                                        {{ $data->Cancelled_On }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                                <th class="w-20">
                                                                    Cancel Comment</th>
                                                                <td class="w-30">
                                                                    @if ($data->Cancelled_Comment)
                                                                        {{ $data->Cancelled_Comment }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th class="w-20">Review Complete By
                                                                </th>
                                                                <td class="w-30">
                                                                    @if ($data->Review_Complete_By)
                                                                        {{ $data->Review_Complete_By }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                                <th class="w-20">
                                                                    Review Complete On</th>
                                                                <td class="w-30">
                                                                    @if ($data->Review_Complete_On)
                                                                        {{ $data->Review_Complete_On }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                                <th class="w-20">
                                                                    Review Complete Comment</th>
                                                                <td class="w-30">
                                                                    @if ($data->Review_Complete_Comment)
                                                                        {{ $data->Review_Complete_Comment }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th class="w-20">More Information Required By</th>
                                                                <td class="w-30">
                                                                    @if ($data->More_Info_Required_By)
                                                                        {{ $data->More_Info_Required_By }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                                <th class="w-20">More Information Required On</th>
                                                                <td class="w-30">
                                                                    @if ($data->more_info_required_on)
                                                                        {{ $data->more_info_required_on }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                                <th class="w-20">
                                                                    More Information Required Comment</th>
                                                                <td class="w-30">
                                                                    @if ($data->More_Info_Required_Comment)
                                                                        {{ $data->More_Info_Required_Comment }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th class="w-20">Cancel By
                                                                </th>
                                                                <td class="w-30">
                                                                    @if ($data->Cancel_By)
                                                                        {{ $data->Cancel_By }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                                <th class="w-20">
                                                                    Cancel On</th>
                                                                <td class="w-30">
                                                                    @if ($data->Cancel_On)
                                                                        {{ $data->Cancel_On }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                                <th class="w-20">
                                                                    Cancel Comment</th>
                                                                <td class="w-30">
                                                                    @if ($data->Cancel_Comment)
                                                                        {{ $data->Cancel_Comment }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th class="w-20">Complete Investigation By
                                                                </th>
                                                                <td class="w-30">
                                                                    @if ($data->Complete_Investigation_By)
                                                                        {{ $data->Complete_Investigation_By }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                                <th class="w-20">
                                                                    Complete Investigation On</th>
                                                                <td class="w-30">
                                                                    @if ($data->Complete_Investigation_On)
                                                                        {{ $data->Complete_Investigation_On }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                                <th class="w-20">
                                                                    Complete Investigation Comment</th>
                                                                <td class="w-30">
                                                                    @if ($data->Complete_Investigation_Comment)
                                                                        {{ $data->Complete_Investigation_Comment }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th class="w-20">More Investigation Required By</th>
                                                                <td class="w-30">
                                                                    @if ($data->More_Investigation_Req_By)
                                                                        {{ $data->More_Investigation_Req_By }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                                <th class="w-20">More Investigation Required On</th>
                                                                <td class="w-30">
                                                                    @if ($data->More_Investigation_Req_On)
                                                                        {{ $data->More_Investigation_Req_On }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                                <th class="w-20">
                                                                    More Investigation Required Comment</th>
                                                                <td class="w-30">
                                                                    @if ($data->More_Investigation_Req_Comment)
                                                                        {{ $data->More_Investigation_Req_Comment }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th class="w-20">Analysis Complete By</th>
                                                                <td class="w-30">
                                                                    @if ($data->Analysis_Complete_By)
                                                                        {{ $data->Analysis_Complete_By }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                                <th class="w-20">Analysis Complete On</th>
                                                                <td class="w-30">
                                                                    @if ($data->Analysis_Complete_On)
                                                                        {{ $data->Analysis_Complete_On }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                                <th class="w-20">
                                                                    Analysis Complete Comment</th>
                                                                <td class="w-30">
                                                                    @if ($data->Analysis_Complete_Comment)
                                                                        {{ $data->Analysis_Complete_Comment }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <th class="w-20">Propose Plan By
                                                                </th>
                                                                <td class="w-30">
                                                                    @if ($data->Propose_Plan_By)
                                                                        {{ $data->Propose_Plan_By }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                                <th class="w-20">
                                                                    Propose Plan On</th>
                                                                <td class="w-30">
                                                                    @if ($data->Propose_Plan_On)
                                                                        {{ $data->Propose_Plan_On }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                                <th class="w-20">
                                                                    Propose Plan Comment</th>
                                                                <td class="w-30">
                                                                    @if ($data->Propose_Plan_Comment)
                                                                        {{ $data->Propose_Plan_Comment }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <th class="w-20">Reject By</th>
                                                                <td class="w-30">
                                                                    @if ($data->Reject_By)
                                                                        {{ $data->Reject_By }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                                <th class="w-20">Reject On</th>
                                                                <td class="w-30">
                                                                    @if ($data->Reject_On)
                                                                        {{ $data->Reject_On }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                                <th class="w-20">
                                                                    Reject Comment</th>
                                                                <td class="w-30">
                                                                    @if ($data->Reject_Comment)
                                                                        {{ $data->Reject_Comment }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <th class="w-20">Approve Plan By</th>
                                                                <td class="w-30">
                                                                    @if ($data->Approve_Plan_By)
                                                                        {{ $data->Approve_Plan_By }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                                <th class="w-20">Approve Plan On</th>
                                                                <td class="w-30">
                                                                    @if ($data->Approve_Plan_On)
                                                                        {{ $data->Approve_Plan_On }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                                <th class="w-20">
                                                                    Approve Plan Comment</th>
                                                                <td class="w-30">
                                                                    @if ($data->Approve_Plan_Comment)
                                                                        {{ $data->Approve_Plan_Comment }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th class="w-20">All CAPA Closed By</th>
                                                                <td class="w-30">
                                                                    @if ($data->All_CAPA_Closed_By)
                                                                        {{ $data->All_CAPA_Closed_By }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                                <th class="w-20">All CAPA Closed On</th>
                                                                <td class="w-30">
                                                                    @if ($data->All_CAPA_Closed_On)
                                                                        {{ $data->All_CAPA_Closed_On }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                                <th class="w-20">
                                                                    All CAPA Closed Comment</th>
                                                                <td class="w-30">
                                                                    @if ($data->All_CAPA_Closed_Comment)
                                                                        {{ $data->All_CAPA_Closed_Comment }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                            </tr>

                                                        </table>
                                                    </div>
                                                </div>
                                            </div>


                                            @if (count($RCA) > 0)
                                                @foreach ($RCA as $data)
                                                    <center>
                                                        <h3>Root Cause Analysis Report</h3>
                                                    </center>

                                                    <div class="inner-block">
                                                        <div class="content-table">
                                                            <div class="block">
                                                                <div class="block-head">
                                                                    General Information
                                                                </div>
                                                                <table>
                                                                    <tr> {{ $data->created_at }} added by
                                                                        {{ $data->originator }}
                                                                        <th class="w-20">Initiator</th>
                                                                        <td class="w-30">
                                                                            {{ Helpers::getInitiatorName($data->initiator_id) }}
                                                                        </td>
                                                                        <th class="w-20">Record Number</th>
                                                                        <td class="w-80">
                                                                            {{ Helpers::divisionNameForQMS($data->division_id) }}/RCA/{{ Helpers::year($data->created_at) }}/{{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}


                                                                    </tr>
                                                                    <tr>
                                                                        <th class="w-20">Site/Location Code</th>
                                                                        <td class="w-30">
                                                                            @if ($data->division_code)
                                                                                {{ $data->division_code }}
                                                                            @else
                                                                                Not Applicable
                                                                            @endif
                                                                        </td>
                                                                        <th class="w-20">Date Initiation</th>
                                                                        <td class="w-80">
                                                                            {{ Helpers::getdateFormat($data->created_at) }}
                                                                        </td>

                                                                    </tr>
                                                                    <tr>

                                                                        <th class="w-20">Due Date</th>
                                                                        <td class="w-30">
                                                                            @if ($data->due_date)
                                                                                {{ Helpers::getdateFormat($data->due_date) }}
                                                                            @else
                                                                                Not Applicable
                                                                            @endif
                                                                        </td>
                                                                        <th class="w-20">Assigned To</th>
                                                                        <td class="w-80">
                                                                            @if ($data->assign_to)
                                                                                {{ Helpers::getInitiatorName($data->assign_to) }}
                                                                            @else
                                                                                Not Applicable
                                                                            @endif
                                                                        </td>

                                                                    </tr>
                                                                    <tr>

                                                                        <th class="w-20">Initiator Department</th>
                                                                        <td class="w-80">
                                                                            @if ($data->initiator_Group)
                                                                                {{ Helpers::getInitiatorGroupFullName($data->initiator_Group) }}
                                                                            @else
                                                                                Not Applicable
                                                                            @endif
                                                                        </td>
                                                                        <th class="w-20">Initiator Department Code
                                                                        </th>
                                                                        <td class="w-30">
                                                                            @if ($data->initiator_group_code)
                                                                                {{ $data->initiator_group_code }}
                                                                            @else
                                                                                Not Applicable
                                                                            @endif
                                                                        </td>

                                                                    </tr>
                                                                    <tr>
                                                                        <th class="w-20">Short Description</th>
                                                                        <td class="w-30" colspan="3">
                                                                            @if ($data->short_description)
                                                                                {{ $data->short_description }}
                                                                            @else
                                                                                Not Applicable
                                                                            @endif
                                                                        </td>

                                                                    </tr>

                                                                    <tr>{{-- <th class="w-20">Additional Investigators</th> <td class="w-30">@if ($data->investigators){{ $data->investigators }}@else Not Applicable @endif</td> --}}
                                                                        <th class="w-20">Severity Level</th>
                                                                        <td class="w-30">
                                                                            @if ($data->severity_level)
                                                                                {{ $data->severity_level }}
                                                                            @else
                                                                                Not Applicable
                                                                            @endif
                                                                        </td>
                                                                        <th class="w-20">Initiated Through</th>
                                                                        <td class="w-80">
                                                                            @if ($data->initiated_through)
                                                                                {{ $data->initiated_through }}
                                                                            @else
                                                                                Not Applicable
                                                                            @endif
                                                                        </td>

                                                                    </tr>
                                                                    <tr>{{-- <th class="w-20">Additional Investigators</th> <td class="w-30">@if ($data->investigators){{ $data->investigators }}@else Not Applicable @endif</td> --}}
                                                                        <th class="w-20">Department Head</th>
                                                                        <td class="w-30">
                                                                            @if ($data->assign_to)
                                                                                {{ Helpers::getInitiatorName($data->assign_to) }}
                                                                            @else
                                                                                Not Applicable
                                                                            @endif
                                                                        </td>
                                                                        <th class="w-20">QA Reviewer</th>
                                                                        <td class="w-80">
                                                                            @if ($data->qa_reviewer)
                                                                                {{ Helpers::getInitiatorName($data->qa_reviewer) }}
                                                                            @else
                                                                                Not Applicable
                                                                            @endif
                                                                        </td>

                                                                    </tr>
                                                                </table>
                                                                <div class="inner-block">
                                                                    <label
                                                                        class="Summer"style="font-weight: bold; font-size: 13px; display: inline-block; width: 75px;">
                                                                        Others</label>
                                                                    <span
                                                                        style="font-size: 0.8rem; margin-left: 60px;">
                                                                        @if ($data->initiated_if_other)
                                                                            {{ $data->initiated_if_other }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </span>
                                                                </div>

                                                                <table>
                                                                    <tr>
                                                                        <th class="w-20">Type</th>
                                                                        <td class="w-30">
                                                                            @if ($data->Type)
                                                                                {{ $data->Type }}
                                                                            @else
                                                                                Not Applicable
                                                                            @endif
                                                                        </td>
                                                                        <th class="w-20">Priority Level</th>
                                                                        <td class="w-80">
                                                                            @if ($data->priority_level)
                                                                                {{ $data->priority_level }}
                                                                            @else
                                                                                Not Applicable
                                                                            @endif
                                                                        </td>

                                                                    </tr>
                                                                    <tr>
                                                                        <th class="w-20">Department(s)</th>
                                                                        <td class="w-80">
                                                                            @if ($data->department)
                                                                                {{ $data->department }}
                                                                            @else
                                                                                Not Applicable
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                                <div class="inner-block">
                                                                    <label
                                                                        class="Summer"style="font-weight: bold; font-size: 13px; display: inline-block; width: 75px;">
                                                                        Description</label>
                                                                    <span
                                                                        style="font-size: 0.8rem; margin-left: 60px;">
                                                                        @if ($data->description)
                                                                            {{ $data->description }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </span>
                                                                </div>

                                                                <div class="inner-block">
                                                                    <label
                                                                        class="Summer"style="font-weight: bold; font-size: 13px; display: inline-block; width: 75px;">
                                                                        Comments</label>
                                                                    <span
                                                                        style="font-size: 0.8rem; margin-left: 60px;">
                                                                        @if ($data->comments)
                                                                            {{ $data->comments }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </span>
                                                                </div>


                                                                <table>
                                                                    <tr>

                                                                        <th class="w-20">Related URL</th>
                                                                        <td class="w-80" colspan="3">
                                                                            @if ($data->related_url)
                                                                                {{ $data->related_url }}
                                                                            @else
                                                                                Not Applicable
                                                                            @endif
                                                                        </td>
                                                                    </tr>

                                                                </table>
                                                                <div class="border-table">
                                                                    <div class="block-head">
                                                                        Initial Attachment
                                                                    </div>
                                                                    <table>

                                                                        <tr class="table_bg">
                                                                            <th class="w-20">S.N.</th>
                                                                            <th class="w-60">Batch No</th>
                                                                        </tr>
                                                                        @if ($data->root_cause_initial_attachment)
                                                                            @foreach (json_decode($data->root_cause_initial_attachment) as $key => $file)
                                                                                <tr>
                                                                                    <td class="w-20">
                                                                                        {{ $key + 1 }}</td>
                                                                                    <td class="w-20"><a
                                                                                            href="{{ asset('upload/' . $file) }}"
                                                                                            target="_blank"><b>{{ $file }}</b></a>
                                                                                    </td>
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
                                                                    Investigation & Root Cause
                                                                </div>


                                                                <div class="inner-block">
                                                                    <label
                                                                        class="Summer"style="font-weight: bold; font-size: 13px; display: inline-block; width: 75px;">
                                                                        Root Cause Methodology </label>
                                                                    <span
                                                                        style="font-size: 0.8rem; margin-left: 60px;">
                                                                        @if ($data->root_cause_methodology)
                                                                            {{ $data->root_cause_methodology }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </span>
                                                                </div>
                                                                <div class="inner-block">
                                                                    <label
                                                                        class="Summer"style="font-weight: bold; font-size: 13px; display: inline-block; width: 75px;">
                                                                        Root Cause Description</label>
                                                                    <span
                                                                        style="font-size: 0.8rem; margin-left: 60px;">
                                                                        @if ($data->root_cause_description)
                                                                            {{ $data->root_cause_description }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </span>
                                                                </div>
                                                                <div class="inner-block">
                                                                    <label
                                                                        class="Summer"style="font-weight: bold; font-size: 13px; display: inline-block; width: 75px;">
                                                                        Investigation Summary</label>
                                                                    <span
                                                                        style="font-size: 0.8rem; margin-left: 60px;">
                                                                        @if ($data->investigation_summary)
                                                                            {{ $data->investigation_summary }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </span>
                                                                </div>

                                                                
                                                                </table>
                                                                <div class="border-table tbl-bottum ">
                                                                    <div class="block-head">
                                                                        Root Cause
                                                                    </div>
                                                                    <table>

                                                                        <tr class="table_bg">
                                                                            <th class="w-10">Row #</th>
                                                                            <th class="w-30">Root Cause Category</th>
                                                                            <th class="w-30">Root Cause Sub-Category
                                                                            </th>
                                                                            <th class="w-30">Probability</th>
                                                                            <th class="w-30">Remarks</th>
                                                                        </tr>
                                                                       
                                                                        @if (!empty($data->Root_Cause_Category))
                                                                            @foreach (unserialize($data->Root_Cause_Category) as $key => $Root_Cause_Category)
                                                                                <tr>
                                                                                    <td class="w-10">
                                                                                        {{ $key + 1 }}</td>
                                                                                    <td class="w-30">
                                                                                        {{ unserialize($data->Root_Cause_Category)[$key] ? unserialize($data->Root_Cause_Category)[$key] : '' }}
                                                                                    </td>
                                                                                    <td class="w-30">
                                                                                        {{ unserialize($data->Root_Cause_Sub_Category)[$key] ? unserialize($data->Root_Cause_Sub_Category)[$key] : '' }}
                                                                                    </td>
                                                                                    <td class="w-30">
                                                                                        {{ unserialize($data->Probability)[$key] ? unserialize($data->Probability)[$key] : '' }}
                                                                                    </td>
                                                                                    <td class="w-30">
                                                                                        {{ unserialize($data->Remarks)[$key] ?? null }}
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                        @else
                                                                        @endif

                                                                    </table>
                                                                </div>

                                                                <div class="border-table  tbl-bottum">
                                                                    <div class="block-head">
                                                                        Failure Mode and Effect Analysis
                                                                    </div>
                                                                    <table>

                                                                        <tr class="table_bg">
                                                                            <th class="w-10">Row #</th>
                                                                            <th class="w-30">Risk Factor</th>
                                                                            <th class="w-30">Risk element</th>
                                                                            <th class="w-30">Probable cause of risk
                                                                                element</th>
                                                                            <th class="w-30">Existing Risk Controls
                                                                            </th>
                                                                        </tr>
                                                                       
                                                                        @if (!empty($data->risk_factor))
                                                                            @foreach (unserialize($data->risk_factor) as $key => $riskFactor)
                                                                                <tr>
                                                                                    <td class="w-10">
                                                                                        {{ $key + 1 }}</td>
                                                                                    <td class="w-30">
                                                                                        {{ $riskFactor }}</td>
                                                                                    <td class="w-30">
                                                                                        {{ unserialize($data->risk_element)[$key] ?? null }}
                                                                                    </td>
                                                                                    <td class="w-30">
                                                                                        {{ unserialize($data->problem_cause)[$key] ?? null }}
                                                                                    </td>
                                                                                    <td class="w-30">
                                                                                        {{ unserialize($data->existing_risk_control)[$key] ?? null }}
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                        @else
                                                                        @endif

                                                                    </table>

                                                                </div>
                                                                <div class="border-table  tbl-bottum">
                                                                    <table>
                                                                        <tr class="table_bg">
                                                                            <th class="w-10">Row #</th>
                                                                            <th class="w-30">Initial Severity-
                                                                                H(3)/M(2)/L(1)</th>
                                                                            <th class="w-30">Initial Probability-
                                                                                H(3)/M(2)/L(1)</th>
                                                                            <th class="w-30">Initial Detectability-
                                                                                H(1)/M(2)/L(3)</th>
                                                                            <th class="w-30">Initial RPN</th>
                                                                        </tr>
                                                                        @if (!empty($data->risk_factor))
                                                                            @foreach (unserialize($data->risk_factor) as $key => $riskFactor)
                                                                                <tr>
                                                                                    <td class="w-10">
                                                                                        {{ $key + 1 }}</td>
                                                                                    <td class="w-30">
                                                                                        {{ unserialize($data->initial_severity)[$key] }}
                                                                                    </td>
                                                                                    <td class="w-30">
                                                                                        {{ unserialize($data->initial_detectability)[$key] }}
                                                                                    </td>
                                                                                    <td class="w-30">
                                                                                        {{ unserialize($data->initial_probability)[$key] }}
                                                                                    </td>
                                                                                    <td class="w-30">
                                                                                        {{ unserialize($data->initial_rpn)[$key] }}
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                        @else
                                                                        @endif
                                                                    </table>
                                                                </div>
                                                                <div class="border-table  tbl-bottum">
                                                                    <table>
                                                                        <tr class="table_bg">
                                                                            <th class="w-10">Row #</th>
                                                                            <th class="w-30">Risk Acceptance (Y/N)
                                                                            </th>
                                                                            <th class="w-30">Proposed Additional Risk
                                                                                control measure (Mandatory for Risk
                                                                                elements
                                                                                having RPN>4)</th>
                                                                            <th class="w-30">Residual Severity-
                                                                                H(3)/M(2)/L(1)</th>
                                                                            <th class="w-30">Residual Probability-
                                                                                H(3)/M(2)/L(1)</th>
                                                                        </tr>
                                                                        @if (!empty($data->risk_factor))
                                                                            @foreach (unserialize($data->risk_factor) as $key => $riskFactor)
                                                                                <tr>
                                                                                    <td class="w-10">
                                                                                        {{ $key + 1 }}</td>
                                                                                    <td class="w-30">
                                                                                        {{ unserialize($data->risk_acceptance)[$key] }}
                                                                                    </td>
                                                                                    <td class="w-30">
                                                                                        {{ unserialize($data->risk_control_measure)[$key] }}
                                                                                    </td>
                                                                                    <td class="w-30">
                                                                                        {{ unserialize($data->residual_severity)[$key] }}
                                                                                    </td>
                                                                                    <td class="w-30">
                                                                                        {{ unserialize($data->residual_probability)[$key] }}
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                        @else
                                                                        @endif
                                                                    </table>
                                                                </div>
                                                                <div class="border-table  tbl-bottum">
                                                                    <table>
                                                                        <tr class="table_bg">
                                                                            <th class="w-10">Row #</th>
                                                                            <th class="w-30">Residual Detectability-
                                                                                H(1)/M(2)/L(3)</th>
                                                                            <th class="w-30">Residual RPN</th>
                                                                            <th class="w-30">Risk Acceptance (Y/N)
                                                                            </th>
                                                                            <th class="w-30">Mitigation proposal
                                                                                (Mention either CAPA reference number,
                                                                                IQ,
                                                                                OQ or PQ)
                                                                            </th>
                                                                        </tr>
                                                                        @if (!empty($data->risk_factor))
                                                                            @foreach (unserialize($data->risk_factor) as $key => $riskFactor)
                                                                                <tr>
                                                                                    <td class="w-10">
                                                                                        {{ $key + 1 }}</td>
                                                                                    <td class="w-30">
                                                                                        {{ unserialize($data->residual_detectability)[$key] }}
                                                                                    </td>
                                                                                    <td class="w-30">
                                                                                        {{ unserialize($data->residual_rpn)[$key] }}
                                                                                    </td>
                                                                                    <td class="w-30">
                                                                                        {{ unserialize($data->risk_acceptance2)[$key] }}
                                                                                    </td>
                                                                                    <td class="w-30">
                                                                                        {{ unserialize($data->mitigation_proposal)[$key] }}
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                        @else
                                                                        @endif
                                                                    </table>
                                                                </div>

                                                                <div class="block-head">
                                                                    Fishbone or Ishikawa Diagram
                                                                </div>
                                                                <table>
                                                                    - <tr>
                                                                        <th class="w-20">Measurement</th>
                                                                        {{-- <td class="w-80">@if ($riskgrdfishbone->measurement){{ $riskgrdfishbone->measurement }}@else Not Applicable @endif</td> --}}
                                                                        <td class="w-80">
                                                                            @php
                                                                                $measurement = unserialize(
                                                                                    $data->measurement,
                                                                                );
                                                                            @endphp

                                                                            @if (is_array($measurement))
                                                                                @foreach ($measurement as $value)
                                                                                    {{ htmlspecialchars($value) }}
                                                                                @endforeach
                                                                            @elseif(is_string($measurement))
                                                                                {{ htmlspecialchars($measurement) }}
                                                                            @else
                                                                                Not Applicable
                                                                            @endif
                                                                        </td>
                                                                        <th class="w-20">Materials</th>
                                                                        {{-- <td class="w-80">@if ($data->materials){{ $data->materials }}@else Not Applicable @endif</td> --}}
                                                                        <td class="w-80">
                                                                            @php
                                                                                $materials = unserialize(
                                                                                    $data->materials,
                                                                                );
                                                                            @endphp

                                                                            @if (is_array($materials))
                                                                                @foreach ($materials as $value)
                                                                                    {{ htmlspecialchars($value) }}
                                                                                @endforeach
                                                                            @elseif(is_string($materials))
                                                                                {{ htmlspecialchars($materials) }}
                                                                            @else
                                                                                Not Applicable
                                                                            @endif
                                                                        </td>

                                                                    </tr>
                                                                    <tr>
                                                                        <th class="w-20">Methods</th>
                                                                        {{-- <td class="w-80">@if ($data->methods){{ $data->methods }}@else Not Applicable @endif</td> --}}
                                                                        <td class="w-80">
                                                                            @php
                                                                                $methods = unserialize($data->methods);
                                                                            @endphp

                                                                            @if (is_array($methods))
                                                                                @foreach ($methods as $value)
                                                                                    {{ htmlspecialchars($value) }}
                                                                                @endforeach
                                                                            @elseif(is_string($methods))
                                                                                {{ htmlspecialchars($methods) }}
                                                                            @else
                                                                                Not Applicable
                                                                            @endif
                                                                        </td>
                                                                        <th class="w-20">Environment</th>
                                                                        {{-- <td class="w-80">@if ($data->environment){{ $data->environment }}@else Not Applicable @endif</td> --}}
                                                                        <td class="w-80">
                                                                            @php
                                                                                $environment = unserialize(
                                                                                    $data->environment,
                                                                                );
                                                                            @endphp

                                                                            @if (is_array($environment))
                                                                                @foreach ($environment as $value)
                                                                                    {{ htmlspecialchars($value) }}
                                                                                @endforeach
                                                                            @elseif(is_string($environment))
                                                                                {{ htmlspecialchars($environment) }}
                                                                            @else
                                                                                Not Applicable
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="w-20">Manpower</th>
                                                                        {{-- <td class="w-80">@if ($data->manpower){{ $data->manpower }}@else Not Applicable @endif</td> --}}
                                                                        <td class="w-80">
                                                                            @php
                                                                                $manpower = unserialize(
                                                                                    $data->manpower,
                                                                                );
                                                                            @endphp

                                                                            @if (is_array($manpower))
                                                                                @foreach ($manpower as $value)
                                                                                    {{ htmlspecialchars($value) }}
                                                                                @endforeach
                                                                            @elseif(is_string($manpower))
                                                                                {{ htmlspecialchars($manpower) }}
                                                                            @else
                                                                                Not Applicable
                                                                            @endif
                                                                        </td>
                                                                        <th class="w-20">Machine</th>
                                                                        {{-- <td class="w-80">@if ($data->machine){{ $data->machine }}@else Not Applicable @endif</td> --}}
                                                                        <td class="w-80">
                                                                            @php
                                                                                $machine = unserialize($data->machine);
                                                                            @endphp

                                                                            @if (is_array($machine))
                                                                                @foreach ($machine as $value)
                                                                                    {{ htmlspecialchars($value) }}
                                                                                @endforeach
                                                                            @elseif(is_string($machine))
                                                                                {{ htmlspecialchars($machine) }}
                                                                            @else
                                                                                Not Applicable
                                                                            @endif
                                                                        </td>
                                                                    </tr>

                                                                </table>
                                                                <div class="inner-block">
                                                                    <label
                                                                        class="Summer"style="font-weight: bold; font-size: 13px; display: inline-block; width: 75px;">
                                                                        Problem Statement1</label>
                                                                    <span
                                                                        style="font-size: 0.8rem; margin-left: 60px;">
                                                                        @if ($data->problem_statement)
                                                                            {{ $data->problem_statement }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </span>
                                                                </div>

                                                                <div class="block-head mt-1">
                                                                    Why-Why Chart
                                                                </div>

                                                                <div class="inner-block">
                                                                    <label
                                                                        class="Summer"style="font-weight: bold; font-size: 13px; display: inline-block; width: 75px;">
                                                                        Problem Statement</label>
                                                                    <span
                                                                        style="font-size: 0.8rem; margin-left: 60px;">
                                                                        @if ($data->why_problem_statement)
                                                                            {{ $data->why_problem_statement }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </span>
                                                                </div>


                                                                <table>


                                                                    <tr>

                                                                        <th class="w-20">Why 1 </th>
                                                                        {{-- <td class="w-80">@if ($data->why_1){{ $data->why_1 }}@else Not Applicable @endif</td> --}}
                                                                        <td class="w-80">
                                                                            @php
                                                                                $why_1 = unserialize($data->why_1);
                                                                            @endphp

                                                                            @if (is_array($why_1))
                                                                                @foreach ($why_1 as $value)
                                                                                    {{ htmlspecialchars($value) }}
                                                                                @endforeach
                                                                            @elseif(is_string($why_1))
                                                                                {{ htmlspecialchars($why_1) }}
                                                                            @else
                                                                                Not Applicable
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="w-20">Why 2</th>
                                                                        {{-- <td class="w-80">@if ($data->why_2){{ $data->why_2 }}@else Not Applicable @endif</td> --}}
                                                                        <td class ="w-80">
                                                                            @php
                                                                                $why_2 = unserialize($data->why_2);
                                                                            @endphp

                                                                            @if (is_array($why_2))
                                                                                @foreach ($why_2 as $value)
                                                                                    {{ htmlspecialchars($value) }}
                                                                                @endforeach
                                                                            @elseif(is_string($why_2))
                                                                                {{ htmlspecialchars($why_2) }}
                                                                            @else
                                                                                Not Applicable
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                    <tr>

                                                                        <th class="w-20">Why 3</th>
                                                                        {{-- <td class="w-80">@if ($data->why_3){{ $data->why_3 }}@else Not Applicable @endif</td> --}}
                                                                        <td class="w-80">
                                                                            @php
                                                                                $why_3 = unserialize($data->why_3);
                                                                            @endphp

                                                                            @if (is_array($why_3))
                                                                                @foreach ($why_3 as $value)
                                                                                    {{ htmlspecialchars($value) }}
                                                                                @endforeach
                                                                            @elseif(is_string($why_3))
                                                                                {{ htmlspecialchars($why_3) }}
                                                                            @else
                                                                                Not Applicable
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="w-20">Why 4</th>
                                                                        {{-- <td class="w-80">@if ($data->why_4){{ $data->why_4 }}@else Not Applicable @endif</td> --}}
                                                                        <td class="w-80">
                                                                            @php
                                                                                $why_4 = unserialize($data->why_4);
                                                                            @endphp

                                                                            @if (is_array($why_4))
                                                                                @foreach ($why_4 as $value)
                                                                                    {{ htmlspecialchars($value) }}
                                                                                @endforeach
                                                                            @elseif(is_string($why_4))
                                                                                {{ htmlspecialchars($why_4) }}
                                                                            @else
                                                                                Not Applicable
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                    <tr>

                                                                        <th class="w-20">Why5</th>
                                                                        {{-- <td class="w-80">@if ($data->why_4){{ $data->why_4 }}@else Not Applicable @endif</td> --}}
                                                                        <td class="w-80" colspan="3">
                                                                            @php
                                                                                $why_5 = unserialize($data->why_5);
                                                                            @endphp

                                                                            @if (is_array($why_5))
                                                                                @foreach ($why_5 as $value)
                                                                                    {{ htmlspecialchars($value) }}
                                                                                @endforeach
                                                                            @elseif(is_string($why_5))
                                                                                {{ htmlspecialchars($why_5) }}
                                                                            @else
                                                                                Not Applicable
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                </table>

                                                                <div class="inner-block">
                                                                    <label class="Summer"
                                                                        style="font-weight: bold; font-size: 13px; display: inline-block; width: 75px;">
                                                                        Root Cause :</label>
                                                                    <span
                                                                        style="font-size: 0.8rem; margin-left: 60px;">
                                                                        @if ($data->why_root_cause)
                                                                            {{ $data->why_root_cause }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </span>
                                                                </div>
                                                                <div class="block-head">
                                                                    Is/Is Not Analysis
                                                                </div>



                                                                <table>
                                                                    <tr>
                                                                        <th class="w-20">What Will Be</th>
                                                                        <td class="w-80">
                                                                            @if ($data->what_will_be)
                                                                                {{ $data->what_will_be }}
                                                                            @else
                                                                                Not Applicable
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="w-20">What Will Not Be </th>
                                                                        <td class="w-80">
                                                                            @if ($data->what_will_not_be)
                                                                                {{ $data->what_will_not_be }}
                                                                            @else
                                                                                Not Applicable
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="w-20">What Will Rationale </th>
                                                                        <td class="w-80">
                                                                            @if ($data->what_rationable)
                                                                                {{ $data->what_rationable }}
                                                                            @else
                                                                                Not Applicable
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="w-20">Where Will Be</th>
                                                                        <td class="w-80">
                                                                            @if ($data->where_will_be)
                                                                                {{ $data->where_will_be }}
                                                                            @else
                                                                                Not Applicable
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="w-20">Where Will Not Be </th>
                                                                        <td class="w-80">
                                                                            @if ($data->where_will_not_be)
                                                                                {{ $data->where_will_not_be }}
                                                                            @else
                                                                                Not Applicable
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="w-20">Where Will Rationale </th>
                                                                        <td class="w-80">
                                                                            @if ($data->where_rationable)
                                                                                {{ $data->where_rationable }}
                                                                            @else
                                                                                Not Applicable
                                                                            @endif
                                                                        </td>

                                                                    <tr>
                                                                        <th class="w-20">When Will Be</th>
                                                                        <td class="w-80">
                                                                            @if ($data->when_will_be)
                                                                                {{ $data->when_will_be }}
                                                                            @else
                                                                                Not Applicable
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="w-20">When Will Not Be </th>
                                                                        <td class="w-80">
                                                                            @if ($data->when_will_not_be)
                                                                                {{ $data->when_will_not_be }}
                                                                            @else
                                                                                Not Applicable
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="w-20">When Will Rationale </th>
                                                                        <td class="w-80">
                                                                            @if ($data->when_rationable)
                                                                                {{ $data->when_rationable }}
                                                                            @else
                                                                                Not Applicable
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="w-20">Coverage Will Be</th>
                                                                        <td class="w-80">
                                                                            @if ($data->coverage_will_be)
                                                                                {{ $data->coverage_will_be }}
                                                                            @else
                                                                                Not Applicable
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="w-20">Coverage Will Not Be </th>
                                                                        <td class="w-80">
                                                                            @if ($data->coverage_will_not_be)
                                                                                {{ $data->coverage_will_not_be }}
                                                                            @else
                                                                                Not Applicable
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="w-20">Coverage Will Rationale
                                                                        </th>
                                                                        <td class="w-80">
                                                                            @if ($data->coverage_rationable)
                                                                                {{ $data->coverage_rationable }}
                                                                            @else
                                                                                Not Applicable
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="w-20">Who Will Be</th>
                                                                        <td class="w-80">
                                                                            @if ($data->who_will_be)
                                                                                {{ $data->who_will_be }}
                                                                            @else
                                                                                Not Applicable
                                                                            @endif
                                                                        </td>
                                                                    </tr>

                                                                    <tr>

                                                                        <th class="w-20">Who Will Not Be </th>
                                                                        <td class="w-80">
                                                                            @if ($data->who_will_not_be)
                                                                                {{ $data->who_will_not_be }}
                                                                            @else
                                                                                Not Applicable
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                    <tr>

                                                                        <th class="w-20">Who Will Rationale </th>
                                                                        <td class="w-80">
                                                                            @if ($data->who_rationable)
                                                                                {{ $data->who_rationable }}
                                                                            @else
                                                                                Not Applicable
                                                                            @endif
                                                                        </td>

                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div class="block">
                                                            <div class="block-head">
                                                                Investigation
                                                            </div>

                                                            <table>


                                                                <tr>
                                                                    <th class="w-20">Objective</th>
                                                                    <td class="w-80">
                                                                        @if ($data->objective)
                                                                            {{ $data->objective }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="w-20">Scope</th>
                                                                    <td class="w-80">
                                                                        @if ($data->scope)
                                                                            {{ $data->scope }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="w-20">Problem Statement</th>
                                                                    <td class="w-80">
                                                                        @if ($data->problem_statement_rca)
                                                                            {{ $data->problem_statement_rca }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="w-20">Background</th>
                                                                    <td class="w-80">
                                                                        @if ($data->requirement)
                                                                            {{ $data->requirement }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="w-20">Immediate Action</th>
                                                                    <td class="w-80">
                                                                        @if ($data->immediate_action)
                                                                            {{ $data->immediate_action }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="w-20">Investigation Team</th>
                                                                    <td class="w-80">
                                                                        @if ($data->investigation_team)
                                                                            {{ Helpers::getInitiatorName($data->investigation_team) }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                               
                                                                <tr>
                                                                    <th class="w-20">Root Cause</th>
                                                                    <td class="w-80">
                                                                        @if ($data->root_cause)
                                                                            {{ $data->root_cause }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="w-20">Impact / Risk Assessment</th>
                                                                    <td class="w-80">
                                                                        @if ($data->impact_risk_assessment)
                                                                            {{ $data->impact_risk_assessment }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="w-20">CAPA</th>
                                                                    <td class="w-80">
                                                                        @if ($data->capa)
                                                                            {{ $data->capa }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="w-20">Investigation Summary</th>
                                                                    <td class="w-80">
                                                                        @if ($data->investigation_summary_rca)
                                                                            {{ $data->investigation_summary_rca }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                </tr>



                                                            </table>
                                                            <div class="border-table">
                                                                <div class="block-head">
                                                                    Investigation Attachment

                                                                </div>
                                                                <table>

                                                                    <tr class="table_bg">
                                                                        <th class="w-20">S.N.</th>
                                                                        <th class="w-60">Batch No</th>
                                                                    </tr>
                                                                    @if ($data->root_cause_initial_attachment_rca)
                                                                        @foreach (json_decode($data->root_cause_initial_attachment_rca) as $key => $file)
                                                                            <tr>
                                                                                <td class="w-20">
                                                                                    {{ $key + 1 }}</td>
                                                                                <td class="w-20"><a
                                                                                        href="{{ asset('upload/' . $file) }}"
                                                                                        target="_blank"><b>{{ $file }}</b></a>
                                                                                </td>
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
                                                                QA Review
                                                            </div>
                                                            <div class="inner-block">
                                                                <label class="Summer"
                                                                    style="font-weight: bold; font-size: 13px; display: inline-block; width: 75px;">
                                                                    QA Review Comments</label>
                                                                <span style="font-size: 0.8rem; margin-left: 60px;">
                                                                    @if ($data->cft_comments_new)
                                                                        {{ $data->cft_comments_new }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </span>
                                                            </div>
                                                            <div class="border-table">
                                                                <div class="block-head">
                                                                    QA Review Attachment

                                                                </div>
                                                                <table>

                                                                    <tr class="table_bg">
                                                                        <th class="w-20">S.N.</th>
                                                                        <th class="w-60">Batch No</th>
                                                                    </tr>
                                                                    @if ($data->cft_attchament_new)
                                                                        @foreach (json_decode($data->cft_attchament_new) as $key => $file)
                                                                            <tr>
                                                                                <td class="w-20">
                                                                                    {{ $key + 1 }}</td>
                                                                                <td class="w-20"><a
                                                                                        href="{{ asset('upload/' . $file) }}"
                                                                                        target="_blank"><b>{{ $file }}</b></a>
                                                                                </td>
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
                                                                HOD Final Review
                                                            </div>
                                                            <div class="inner-block">
                                                                <label class="Summer"
                                                                    style="font-weight: bold; font-size: 13px; display: inline-block; width: 75px;">
                                                                    HOD Final Review Comments</label>
                                                                <span style="font-size: 0.8rem; margin-left: 60px;">
                                                                    @if ($data->hod_final_comments)
                                                                        {{ $data->hod_final_comments }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </span>
                                                            </div>
                                                            <div class="border-table">
                                                                <div class="block-head">
                                                                    HOD Final Review Attachment

                                                                </div>
                                                                <table>

                                                                    <tr class="table_bg">
                                                                        <th class="w-20">S.N.</th>
                                                                        <th class="w-60">Batch No</th>
                                                                    </tr>
                                                                    @if ($data->hod_final_attachments)
                                                                        @foreach (json_decode($data->hod_final_attachments) as $key => $file)
                                                                            <tr>
                                                                                <td class="w-20">
                                                                                    {{ $key + 1 }}</td>
                                                                                <td class="w-20"><a
                                                                                        href="{{ asset('upload/' . $file) }}"
                                                                                        target="_blank"><b>{{ $file }}</b></a>
                                                                                </td>
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
                                                                QA Final Review
                                                            </div>
                                                            <div class="inner-block">
                                                                <label class="Summer"
                                                                    style="font-weight: bold; font-size: 13px; display: inline-block; width: 75px;">
                                                                    QA Final Review Comments</label>
                                                                <span style="font-size: 0.8rem; margin-left: 60px;">
                                                                    @if ($data->qa_final_comments)
                                                                        {{ $data->qa_final_comments }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </span>
                                                            </div>
                                                            <div class="border-table">
                                                                <div class="block-head">
                                                                    QA Final Review Attachment

                                                                </div>
                                                                <table>

                                                                    <tr class="table_bg">
                                                                        <th class="w-20">S.N.</th>
                                                                        <th class="w-60">Batch No</th>
                                                                    </tr>
                                                                    @if ($data->qa_final_attachments)
                                                                        @foreach (json_decode($data->qa_final_attachments) as $key => $file)
                                                                            <tr>
                                                                                <td class="w-20">
                                                                                    {{ $key + 1 }}</td>
                                                                                <td class="w-20"><a
                                                                                        href="{{ asset('upload/' . $file) }}"
                                                                                        target="_blank"><b>{{ $file }}</b></a>
                                                                                </td>
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
                                                                QAH/CQAH Final Review
                                                            </div>
                                                            <div class="inner-block">
                                                                <label class="Summer"
                                                                    style="font-weight: bold; font-size: 13px; display: inline-block; width: 75px;">
                                                                    QAH/CQAH Final Review Comments</label>
                                                                <span style="font-size: 0.8rem; margin-left: 60px;">
                                                                    @if ($data->qah_final_comments)
                                                                        {{ $data->qah_final_comments }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </span>
                                                            </div>
                                                            <div class="border-table">
                                                                <div class="block-head">
                                                                    QAH/CQAH Final Review Attachment

                                                                </div>
                                                                <table>

                                                                    <tr class="table_bg">
                                                                        <th class="w-20">S.N.</th>
                                                                        <th class="w-60">Batch No</th>
                                                                    </tr>
                                                                    @if ($data->qah_final_attachments)
                                                                        @foreach (json_decode($data->qah_final_attachments) as $key => $file)
                                                                            <tr>
                                                                                <td class="w-20">
                                                                                    {{ $key + 1 }}</td>
                                                                                <td class="w-20"><a
                                                                                        href="{{ asset('upload/' . $file) }}"
                                                                                        target="_blank"><b>{{ $file }}</b></a>
                                                                                </td>
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
                                                                Activity log
                                                            </div>
                                                            <table>

                                                                <tr>
                                                                    <th class="w-20">Acknowledge By</th>
                                                                    <td class="w-30">
                                                                        @if ($data->acknowledge_by)
                                                                            {{ $data->acknowledge_by }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                    <th class="w-20">Acknowledge On</th>
                                                                    <td class="w-30">
                                                                        @if ($data->acknowledge_on)
                                                                            {{ Helpers::getdateFormat($data->acknowledge_on) }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                <tr>
                                                                    <th class="w-20"> Comment</th>
                                                                    <td class="w-80">
                                                                        @if ($data->acknowledge_comment)
                                                                            {{ $data->acknowledge_comment }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                </tr>

                                                               
                                                                <tr>
                                                                    <th class="w-20">QA/CQA Review Complete By</th>
                                                                    <td class="w-30">
                                                                        @if ($data->QQQA_Review_Complete_By)
                                                                            {{ $data->QQQA_Review_Complete_By }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                    <th class="w-20">QA/CQA Review Complete On</th>
                                                                    <td class="w-30">
                                                                        @if ($data->QQQA_Review_Complete_On)
                                                                            {{ Helpers::getdateFormat($data->QQQA_Review_Complete_On) }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                    <th class="w-20">Sumitted Comment</th>
                                                                    <td class="w-80">
                                                                        @if ($data->QAQQ_Review_Complete_comment)
                                                                            {{ $data->QAQQ_Review_Complete_comment }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                   
                                                                    <th class="w-20">HOD Review Complete By</th>
                                                                    <td class="w-30">
                                                                        @if ($data->HOD_Review_Complete_By)
                                                                            {{ $data->HOD_Review_Complete_By }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                    <th class="w-20">HOD Review Complete On</th>
                                                                    <td class="w-30">
                                                                        @if ($data->HOD_Review_Complete_On)
                                                                            {{ Helpers::getdateFormat($data->HOD_Review_Complete_On) }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                    <th class="w-20"> Comment</th>
                                                                    <td class="w-80">
                                                                        @if ($data->HOD_Review_Complete_Comment)
                                                                            {{ $data->HOD_Review_Complete_Comment }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                    
                                                                <tr>
                                                                    <th class="w-20">Submit By</th>
                                                                    <td class="w-30">
                                                                        @if ($data->submitted_by)
                                                                            {{ $data->submitted_by }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                    <th class="w-20">Submit On</th>
                                                                    <td class="w-30">
                                                                        @if ($data->submitted_on)
                                                                            {{ Helpers::getdateFormat($data->submitted_on) }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                    <th class="w-20"> Comment</th>
                                                                    <td class="w-30">
                                                                        @if ($data->qa_comments_new)
                                                                            {{ $data->qa_comments_new }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                </tr>


                                                                <tr>
                                                                    <th class="w-20">HOD Final Review Completed By
                                                                    </th>
                                                                    <td class="w-30">
                                                                        {{ $data->hod_final_review_completed_by }}
                                                                    </td>
                                                                    <th class="w-20">HOD Final Review Completed On
                                                                    </th>
                                                                    <td class="w-30">
                                                                        {{ $data->hod_final_review_completed_on }}
                                                                    </td>
                                                                    <th class="w-20">
                                                                        Comment</th>
                                                                    <td class="w-30">
                                                                        {{ $data->HOD_Final_Review_Complete_Comment }}
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <th class="w-20"> FinalQA/CQA Review Complete By
                                                                    </th>
                                                                    <td class="w-30">
                                                                        @if ($data->Final_QA_Review_Complete_By)
                                                                            {{ $data->Final_QA_Review_Complete_By }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                    <th class="w-20"> FinalQA/CQA Review Complete On
                                                                    </th>
                                                                    <td class="w-30">
                                                                        @if ($data->Final_QA_Review_Complete_On)
                                                                            {{ Helpers::getdateFormat($data->Final_QA_Review_Complete_On) }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                    <th class="w-20"> Comment</th>
                                                                    <td class="w-80">
                                                                        @if ($data->evalution_Closure_comment)
                                                                            {{ $data->Final_QA_Review_Complete_Comment }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <th class="w-20">QAH/CQAH Closure By</th>
                                                                    <td class="w-30">
                                                                        @if ($data->evaluation_complete_by)
                                                                            {{ $data->evaluation_complete_by }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                    <th class="w-20">QAH/CQAH Closure On</th>
                                                                    <td class="w-30">
                                                                        @if ($data->evaluation_complete_on)
                                                                            {{ Helpers::getdateFormat($data->evaluation_complete_on) }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                    <th class="w-20">
                                                                        Comment</th>
                                                                    <td class="w-80">
                                                                        @if ($data->Final_QA_Review_Complete_Comment)
                                                                            {{ $data->evalution_Closure_comment }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="w-20">Cancelled By
                                                                    </th>
                                                                    <td class="w-30">
                                                                        @if ($data->cancelled_by)
                                                                            {{ $data->cancelled_by }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    <th class="w-20">
                                                                        Cancelled On</th>
                                                                    <td class="w-30">
                                                                        @if ($data->cancelled_on)
                                                                            {{ $data->cancelled_on }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    <th class="w-20">
                                                                        Comments</th>
                                                                    <td class="w-30">
                                                                        @if ($data->cancel_comment)
                                                                            {{ $data->cancel_comment }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                </tr>

                                                            </table>
                                                        </div>
                                                    </div>
                                        </div>
                                        @endforeach
                                        @endif

                                        @if (count($ActionItem) > 0)
                                            @foreach ($ActionItem as $data)
                                                <center>
                                                    <h3>Action Item Report</h3>
                                                </center>

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
                                                                        @if ($data->record)
                                                                            {{ Helpers::divisionNameForQMS($data->division_id) }}/AI/{{ date('Y') }}/{{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                    <th class="w-20">Division Code</th>
                                                                    <td class="w-30">
                                                                        @if ($data->division_id)
                                                                            {{ Helpers::getDivisionName($data->division_id) }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                </tr>

                                                                <tr> {{ $data->created_at }} added by
                                                                    {{ $data->originator }}
                                                                    <th class="w-20">Initiator</th>
                                                                    <td class="w-30">
                                                                        {{ Helpers::getInitiatorName($data->initiator_id) }}
                                                                    </td>
                                                                    <th class="w-20">Date of Initiation</th>
                                                                    <td class="w-30">
                                                                        {{ Helpers::getdateFormat($data->created_at) }}
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <th class="w-20">Parent Record Number</th>
                                                                    <td class="w-30">
                                                                        @if ($data->parent_record_number)
                                                                            {{ $data->parent_record_number }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                    <th class="w-20">Assigned To</th>
                                                                    <td class="w-30">
                                                                        @if ($data->assign_to)
                                                                            {{ Helpers::getInitiatorName($data->assign_to) }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                </tr>


                                                                <tr>
                                                                    <th class="w-20">Due Date</th>
                                                                    <td class="w-30">
                                                                        @if ($data->due_date)
                                                                            {{ Helpers::getdateFormat($data->due_date) }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            </table>

                                                            <label class="head-number" for="Short Description">Short
                                                                Description</label>
                                                            <div class="div-data">
                                                                @if ($data->short_description)
                                                                    {{ $data->short_description }}
                                                                @else
                                                                    Not Applicable
                                                                @endif
                                                            </div>

                                                            <label class="head-number"
                                                                for="Action Item Related Records">Action Item Related
                                                                Records</label>
                                                            <div class="div-data">
                                                                @if ($data->Reference_Recores1)
                                                                    {{ str_replace(',', ', ', $data->Reference_Recores1) }}
                                                                @else
                                                                    Not Applicable
                                                                @endif
                                                            </div>

                                                            <table>
                                                                <tr>
                                                                    <th class="w-20">HOD Persons</th>
                                                                    <td class="w-80">
                                                                        @if ($data->hod_preson)
                                                                            {{ $data->hod_preson }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            </table>

                                                            <table>
                                                                <tr>
                                                                    <th class="w-20">Responsible Department</th>
                                                                    <td class="w-80">
                                                                        @if ($data->departments)
                                                                            {{ $data->departments }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            </table>

                                                            <label class="head-number"
                                                                for="Description">Description</label>
                                                            <div class="div-data">
                                                                @if ($data->description)
                                                                    {{ $data->description }}
                                                                @else
                                                                    Not Applicable
                                                                @endif
                                                            </div>

                                                            <div class="block-head">
                                                                File Attachments
                                                            </div>
                                                            <div class="border-table">
                                                                <table>
                                                                    <tr class="table_bg">
                                                                        <th class="w-20">S.N.</th>
                                                                        <th class="w-60">File</th>
                                                                    </tr>
                                                                    @if ($data->file_attach)
                                                                        @php $files = json_decode($data->file_attach); @endphp
                                                                        @if (count($files) > 0)
                                                                            @foreach ($files as $key => $file)
                                                                                <tr>
                                                                                    <td class="w-20">
                                                                                        {{ $key + 1 }}</td>
                                                                                    <td class="w-60"><a
                                                                                            href="{{ asset('upload/' . $file) }}"
                                                                                            target="_blank"><b>{{ $file }}</b></a>
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                        @else
                                                                            <tr>
                                                                                <td class="w-20">1</td>
                                                                                <td class="w-60">Not Applicable</td>
                                                                            </tr>
                                                                        @endif
                                                                    @else
                                                                        <tr>
                                                                            <td class="w-20">1</td>
                                                                            <td class="w-60">Not Applicable</td>
                                                                        </tr>
                                                                    @endif
                                                                </table>
                                                            </div>

                                                        </div>

                                                        <div class="block">
                                                            <div class="block-head">
                                                                Post Completion
                                                            </div>

                                                            <label class="head-number" for="Action Taken">Action
                                                                Taken</label>
                                                            <div class="div-data">
                                                                @if ($data->action_taken)
                                                                    {{ $data->action_taken }}
                                                                @else
                                                                    Not Applicable
                                                                @endif
                                                            </div>
                                                            <table>
                                                                <tr>
                                                                    <th class="w-20">Action Start Date</th>
                                                                    <td class="w-30">
                                                                        @if ($data->start_date)
                                                                            {{ Helpers::getdateFormat($data->start_date) }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                    <th class="w-20">Actual End Date</th>
                                                                    <td class="w-30">
                                                                        @if ($data->end_date)
                                                                            {{ Helpers::getdateFormat($data->end_date) }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            </table>

                                                            <label class="head-number"
                                                                for="Comments">Comments</label>
                                                            <div class="div-data">
                                                                @if ($data->comments)
                                                                    {{ $data->comments }}
                                                                @else
                                                                    Not Applicable
                                                                @endif
                                                            </div>


                                                            <div class="block-head">
                                                                Completion Attachments
                                                            </div>
                                                            <div class="border-table">
                                                                <table>
                                                                    <tr class="table_bg">
                                                                        <th class="w-20">S.N.</th>
                                                                        <th class="w-60">File</th>
                                                                    </tr>
                                                                    @if ($data->Support_doc)
                                                                        @php $files = json_decode($data->Support_doc); @endphp
                                                                        @if (count($files) > 0)
                                                                            @foreach ($files as $key => $file)
                                                                                <tr>
                                                                                    <td class="w-20">
                                                                                        {{ $key + 1 }}</td>
                                                                                    <td class="w-60"><a
                                                                                            href="{{ asset('upload/' . $file) }}"
                                                                                            target="_blank"><b>{{ $file }}</b></a>
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                        @else
                                                                            <tr>
                                                                                <td class="w-20">1</td>
                                                                                <td class="w-60">Not Applicable</td>
                                                                            </tr>
                                                                        @endif
                                                                    @else
                                                                        <tr>
                                                                            <td class="w-20">1</td>
                                                                            <td class="w-60">Not Applicable</td>
                                                                        </tr>
                                                                    @endif
                                                                </table>
                                                            </div>
                                                        </div>

                                                        <div class="block">
                                                            <div class="block-head">
                                                                Action Approval
                                                            </div>

                                                            <label class="head-number" for="QA Review Comments">QA
                                                                Review Comments</label>
                                                            <div class="div-data">
                                                                @if ($data->qa_comments)
                                                                    {{ $data->qa_comments }}
                                                                @else
                                                                    Not Applicable
                                                                @endif
                                                            </div>

                                                        </div>

                                                        <div class="block">
                                                            <div class="block-head">
                                                                Extension Justification
                                                            </div>
                                                            <table>
                                                                <tr>
                                                                    <th class="w-20">Due Date Extension
                                                                        Justification</th>
                                                                    <td class="w-80">
                                                                        @if ($data->due_date_extension)
                                                                            {{ $data->due_date_extension }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            </table>

                                                            <div class="block-head">
                                                                Action Approval Attachment
                                                            </div>
                                                            <div class="border-table">
                                                                <table>
                                                                    <tr class="table_bg">
                                                                        <th class="w-20">S.N.</th>
                                                                        <th class="w-60">File</th>
                                                                    </tr>
                                                                    @if ($data->final_attach)
                                                                        @php $files = json_decode($data->final_attach); @endphp
                                                                        @if (count($files) > 0)
                                                                            @foreach ($files as $key => $file)
                                                                                <tr>
                                                                                    <td class="w-20">
                                                                                        {{ $key + 1 }}</td>
                                                                                    <td class="w-60"><a
                                                                                            href="{{ asset('upload/' . $file) }}"
                                                                                            target="_blank"><b>{{ $file }}</b></a>
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                        @else
                                                                            <tr>
                                                                                <td class="w-20">1</td>
                                                                                <td class="w-60">Not Applicable</td>
                                                                            </tr>
                                                                        @endif
                                                                    @else
                                                                        <tr>
                                                                            <td class="w-20">1</td>
                                                                            <td class="w-60">Not Applicable</td>
                                                                        </tr>
                                                                    @endif
                                                                </table>
                                                            </div>
                                                        </div>

                                                        <div class="block" style="margin-top: 15px;">
                                                            <div class="block-head">
                                                                Activity Log
                                                            </div>
                                                            <table>
                                                                <tr>
                                                                    <th class="w-20">Submitted By</th>
                                                                    <td class="w-80">{{ $data->submitted_by }}
                                                                    </td>
                                                                    <th class="w-20">Submitted On</th>
                                                                    <td class="w-80">{{ $data->submitted_on }}
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <th class="w-20">Comment</th>
                                                                    <td class="w-80">
                                                                        {{ $data->submitted_comment }}</td>
                                                                </tr>

                                                                <tr>
                                                                    <th class="w-20">Cancelled By</th>
                                                                    <td class="w-80">{{ $data->cancelled_by }}
                                                                    </td>
                                                                    <th class="w-20">Cancelled On</th>
                                                                    <td class="w-80">{{ $data->cancelled_on }}
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <th class="w-20">Comment</th>
                                                                    <td class="w-80">
                                                                        {{ $data->cancelled_comment }}</td>
                                                                </tr>

                                                                <tr>
                                                                    <th class="w-20">Acknowledge By</th>
                                                                    <td class="w-80">
                                                                        {{ $data->acknowledgement_by }}</td>
                                                                    <th class="w-20">Acknowledge On</th>
                                                                    <td class="w-80">
                                                                        {{ $data->acknowledgement_on }}</td>
                                                                </tr>

                                                                <tr>
                                                                    <th class="w-20">Comment</th>
                                                                    <td class="w-80">
                                                                        {{ $data->acknowledgement_comment }}</td>
                                                                </tr>

                                                                <tr>
                                                                    <th class="w-20">Work Completion By</th>
                                                                    <td class="w-80">
                                                                        {{ $data->work_completion_by }}</td>
                                                                    <th class="w-20">Work Completion On</th>
                                                                    <td class="w-80">
                                                                        {{ $data->work_completion_on }}</td>
                                                                </tr>

                                                                <tr>
                                                                    <th class="w-20">Comment</th>
                                                                    <td class="w-80">
                                                                        {{ $data->work_completion_comment }}</td>
                                                                </tr>

                                                                <tr>
                                                                    <th class="w-20">QA/CQA Verification By</th>
                                                                    <td class="w-80">
                                                                        {{ $data->qa_varification_by }}</td>
                                                                    <th class="w-20">QA/CQA Verification On</th>
                                                                    <td class="w-80">
                                                                        {{ $data->qa_varification_on }}</td>
                                                                </tr>

                                                                <tr>
                                                                    <th class="w-20">Comment</th>
                                                                    <td class="w-80">
                                                                        {{ $data->qa_varification_comment }}</td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif

                                        @if (count($CAPA) > 0)
                                            @foreach ($CAPA as $data)
                                                <center>
                                                    <h3>CAPA Report</h3>
                                                </center>

                                                <div class="inner-block">
                                                    <div class="content-table">
                                                        <div class="block">
                                                            <div class="block-head">
                                                                General Information
                                                            </div>
                                                            <table>

                                                                <tr>
                                                                    <th class="w-20">Record Number</th>
                                                                    <td class="w-80">
                                                                        {{ Helpers::divisionNameForQMS($data->division_id) }}/CAPA/{{ date('Y') }}/{{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}
                                                                    </td>
                                                                    <th class="w-20">Site/Location Code</th>
                                                                    <td class="w-80">
                                                                        @if ($data->division_id)
                                                                            {{ Helpers::getDivisionName($data->division_id) }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                </tr>

                                                                <tr> {{ $data->created_at }} added by
                                                                    {{ $data->originator }}
                                                                    <th class="w-20">Initiator</th>
                                                                    <td class="w-80">{{ $data->originator }}</td>
                                                                    <th class="w-20">Date of Initiation</th>
                                                                    <td class="w-80">
                                                                        {{ Helpers::getdateFormat($data->intiation_date) }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="w-20">Assigned To</th>
                                                                    <td class="w-80">
                                                                        @if ($data->assign_to)
                                                                            {{ $data->assign_to }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                    <th class="w-20">Due Date</th>
                                                                    <td class="w-80">
                                                                        @if ($data->due_date)
                                                                            {{ Helpers::getdateFormat($data->due_date) }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <th class="w-20">Department Group</th>
                                                                    @php
                                                                        $departments = [
                                                                            'CQA' => 'Corporate Quality Assurance',
                                                                            'QAB' => 'Quality Assurance Biopharma',
                                                                            'CQC' => 'Central Quality Control',
                                                                            'PSG' => 'Plasma Sourcing Group',
                                                                            'CS' => 'Central Stores',
                                                                            'ITG' => 'Information Technology Group',
                                                                            'MM' => 'Molecular Medicine',
                                                                            'CL' => 'Central Laboratory',
                                                                            'TT' => 'Tech Team',
                                                                            'QA' => 'Quality Assurance',
                                                                            'QM' => 'Quality Management',
                                                                            'IA' => 'IT Administration',
                                                                            'ACC' => 'Accounting',
                                                                            'LOG' => 'Logistics',
                                                                            'SM' => 'Senior Management',
                                                                            'BA' => 'Business Administration',
                                                                        ];
                                                                    @endphp
                                                                    <td class="w-80">
                                                                        {{ $departments[$data->initiator_Group] ?? 'Not Application' }}
                                                                    </td>

                                                                    <th class="w-20">Department Group Code</th>
                                                                    <td class="w-80">
                                                                        @if ($data->initiator_group_code)
                                                                            {{ $data->initiator_group_code }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            </table>

                                                            <label class="head-number" for="Short Description">Short
                                                                Description</label>
                                                            <div class="div-data">
                                                                @if ($data->short_description)
                                                                    {{ $data->short_description }}
                                                                @else
                                                                    Not Applicable
                                                                @endif
                                                            </div>

                                                            <label class="head-number" for="Product Name">Product
                                                                Name</label>
                                                            <div class="div-data">
                                                                @if ($data->product_name)
                                                                    {{ $data->product_name }}
                                                                @else
                                                                    Not Applicable
                                                                @endif
                                                            </div>

                                                            <label class="head-number"
                                                                for="CAPA Source & Number">CAPA Source &
                                                                Number</label>
                                                            <div class="div-data">
                                                                @if ($data->capa_source_number)
                                                                    {{ $data->capa_source_number }}
                                                                @else
                                                                    Not Applicable
                                                                @endif
                                                            </div>

                                                            <table>
                                                                <tr>
                                                                    <th class="w-20">Initiated Through</th>
                                                                    <td class="w-80">
                                                                        @if ($data->initiated_through)
                                                                            {{ $data->initiated_through }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                    <th class="w-20">Others</th>
                                                                    <td class="w-80">
                                                                        @if ($data->initiated_through_req)
                                                                            {{ $data->initiated_through_req }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="w-20">Repeat</th>
                                                                    <td class="w-80">
                                                                        @if ($data->repeat)
                                                                            {{ $data->repeat }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                    <th class="w-20">Repeat Nature</th>
                                                                    <td class="w-80">
                                                                        @if ($data->repeat_nature)
                                                                            {{ $data->repeat_nature }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            </table>

                                                            <label class="head-number"
                                                                for="Problem Description">Problem Description</label>
                                                            <div class="div-data">
                                                                @if ($data->problem_description)
                                                                    {{ $data->problem_description }}
                                                                @else
                                                                    Not Applicable
                                                                @endif
                                                            </div>

                                                            <table>
                                                                <tr>
                                                                    <th class="w-20">CAPA Team</th>
                                                                    <td class="w-80">
                                                                        @if ($data->capa_team)
                                                                            {{ $capa_teamNamesString }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>

                                                                    <th class="w-20">Reference Records</th>
                                                                    <td class="w-80">
                                                                        @if ($data->capa_related_record)
                                                                            {{ str_replace(',', ', ', $data->capa_related_record) }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <label class="head-number"
                                                                for="Initial Observation">Initial Observation</label>
                                                            <div class="div-data">
                                                                @if ($data->initial_observation)
                                                                    {{ $data->initial_observation }}
                                                                @else
                                                                    Not Applicable
                                                                @endif
                                                            </div>

                                                            <table>
                                                                <tr>
                                                                    <th class="w-20">Interim Containnment</th>
                                                                    <td class="w-80">
                                                                        @if ($data->interim_containnment)
                                                                            {{ $data->interim_containnment }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            </table>

                                                            <label class="head-number"
                                                                for="Containment Comments">Containment
                                                                Comments</label>
                                                            <div class="div-data">
                                                                @if ($data->containment_comments)
                                                                    {{ $data->containment_comments }}
                                                                @else
                                                                    Not Applicable
                                                                @endif
                                                            </div>

                                                            <div class="block-head">
                                                                Capa Attachement
                                                            </div>
                                                            <div class="border-table">
                                                                <table>
                                                                    <tr class="table_bg">
                                                                        <th class="w-20">S.N.</th>
                                                                        <th class="w-60">File </th>
                                                                    </tr>
                                                                    @if ($data->capa_attachment)
                                                                        @foreach (json_decode($data->capa_attachment) as $key => $file)
                                                                            <tr>
                                                                                <td class="w-20">
                                                                                    {{ $key + 1 }}</td>
                                                                                <td class="w-20"><a
                                                                                        href="{{ asset('upload/' . $file) }}"
                                                                                        target="_blank"><b>{{ $file }}</b></a>
                                                                                </td>
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

                                                            <label class="head-number"
                                                                for="Investigation">Investigation</label>
                                                            <div class="div-data">
                                                                @if ($data->investigation)
                                                                    {{ $data->investigation }}
                                                                @else
                                                                    Not Applicable
                                                                @endif
                                                            </div>

                                                            <label class="head-number"
                                                                for="Root Cause Analysis">Root Cause Analysis</label>
                                                            <div class="div-data">
                                                                @if ($data->rcadetails)
                                                                    {{ $data->rcadetails }}
                                                                @else
                                                                    Not Applicable
                                                                @endif
                                                            </div>

                                                        </div>

                                                        <div class="block">
                                                            <div class="block-head">
                                                                Equipment/Material Info
                                                            </div>
                                                            <table>
                                                                <tr>
                                                                    <th class="w-20">Severity Level</th>
                                                                    <td class="w-80">
                                                                        @if ($data->severity_level_form)
                                                                            {{ $data->severity_level_form }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                        <div class="block">
                                                            <div class="block-head">
                                                                Other type CAPA Details
                                                            </div>
                                                            <table>
                                                                <tr>
                                                                    <th class="w-20">Details</th>
                                                                    <td class="w-80">
                                                                        @if ($data->details_new)
                                                                            {{ $data->details_new }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>

                              




                                                        <div class="block">
                                                            <div class="block-head">
                                                                CAPA Details
                                                            </div>
                                                            <table>
                                                                <tr>
                                                                    <th class="w-20">CAPA Type</th>
                                                                    <td class="w-80">
                                                                        @if ($data->capa_type)
                                                                            {{ $data->capa_type }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            </table>

                                                            <label class="head-number"
                                                                for="Corrective Action">Corrective Action</label>
                                                            <div class="div-data">
                                                                @if ($data->corrective_action)
                                                                    {{ $data->corrective_action }}
                                                                @else
                                                                    Not Applicable
                                                                @endif
                                                            </div>

                                                            <label class="head-number"
                                                                for="Preventive Action">Preventive Action</label>
                                                            <div class="div-data">
                                                                @if ($data->preventive_action)
                                                                    {{ $data->preventive_action }}
                                                                @else
                                                                    Not Applicable
                                                                @endif
                                                            </div>

                                                            <div class="block-head">
                                                                File Attachment
                                                            </div>
                                                            <div class="border-table">
                                                                <table>
                                                                    <tr class="table_bg">
                                                                        <th class="w-20">S.N.</th>
                                                                        <th class="w-60">File </th>
                                                                    </tr>
                                                                    @if ($data->capafileattachement)
                                                                        @foreach (json_decode($data->capafileattachement) as $key => $file)
                                                                            <tr>
                                                                                <td class="w-20">
                                                                                    {{ $key + 1 }}</td>
                                                                                <td class="w-20"><a
                                                                                        href="{{ asset('upload/' . $file) }}"
                                                                                        target="_blank"><b>{{ $file }}</b></a>
                                                                                </td>
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
                                                                HOD Review
                                                            </div>
                                                            <div>
                                                                <table>
                                                                    <tr>
                                                                        <th class="w-20">HOD Remark</th>
                                                                        <td class="w-80">
                                                                            @if ($data->hod_remarks)
                                                                                {{ $data->hod_remarks }}
                                                                            @else
                                                                                Not Applicable
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </div>

                                                            <div class="block-head">
                                                                HOD Review Attachement
                                                            </div>
                                                            <div class="border-table">
                                                                <table>
                                                                    <tr class="table_bg">
                                                                        <th class="w-20">S.N.</th>
                                                                        <th class="w-60">File </th>
                                                                    </tr>
                                                                    @if ($data->hod_attachment)
                                                                        @foreach (json_decode($data->hod_attachment) as $key => $file)
                                                                            <tr>
                                                                                <td class="w-20">
                                                                                    {{ $key + 1 }}</td>
                                                                                <td class="w-20"><a
                                                                                        href="{{ asset('upload/' . $file) }}"
                                                                                        target="_blank"><b>{{ $file }}</b></a>
                                                                                </td>
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
                                                                QA Review
                                                            </div>
                                                            <div>
                                                                <table>
                                                                    <tr>
                                                                        <th class="w-20">CAPA QA Review</th>
                                                                        <td class="w-80">
                                                                            @if ($data->capa_qa_comments)
                                                                                {{ $data->capa_qa_comments }}
                                                                            @else
                                                                                Not Applicable
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                </table>

                                                                <div class="block-head">
                                                                    QA Attachment
                                                                </div>
                                                                <div class="border-table">
                                                                    <table>
                                                                        <tr class="table_bg">
                                                                            <th class="w-20">S.N.</th>
                                                                            <th class="w-60">File </th>
                                                                        </tr>
                                                                        @if ($data->qa_attachment)
                                                                            @foreach (json_decode($data->qa_attachment) as $key => $file)
                                                                                <tr>
                                                                                    <td class="w-20">
                                                                                        {{ $key + 1 }}</td>
                                                                                    <td class="w-20"><a
                                                                                            href="{{ asset('upload/' . $file) }}"
                                                                                            target="_blank"><b>{{ $file }}</b></a>
                                                                                    </td>
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
                                                        </div>


                                                        <br>
                                                        <div class="block">
                                                            <div class="block-head">
                                                                CAPA Closure
                                                            </div>
                                                            <table>
                                                                <tr>
                                                                    <th class="w-20">
                                                                        QA Head Review & Closure
                                                                    </th>
                                                                    <td class="w-80">
                                                                        @if ($data->qa_review)
                                                                            {{ $data->qa_review }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="w-20">Due Date Extension
                                                                        Justification</th>
                                                                    <td class="w-80">
                                                                        @if ($data->due_date_extension)
                                                                            {{ $data->due_date_extension }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            </table>

                                                            <div class="block-head">
                                                                Closure Attachment
                                                            </div>
                                                            <div class="border-table">
                                                                <table>
                                                                    <tr class="table_bg">
                                                                        <th class="w-20">S.N.</th>
                                                                        <th class="w-60">File </th>
                                                                    </tr>
                                                                    @if ($data->closure_attachment)
                                                                        @foreach (json_decode($data->closure_attachment) as $key => $file)
                                                                            <tr>
                                                                                <td class="w-20">
                                                                                    {{ $key + 1 }}</td>
                                                                                <td class="w-20"><a
                                                                                        href="{{ asset('upload/' . $file) }}"
                                                                                        target="_blank"><b>{{ $file }}</b></a>
                                                                                </td>
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
                                                                HOD Final Review
                                                            </div>
                                                            <div>
                                                                <table>
                                                                    <tr>
                                                                        <th class="w-20">HOD Final Review Comment
                                                                        </th>
                                                                        <td class="w-80">
                                                                            @if ($data->hod_final_review)
                                                                                {{ $data->hod_final_review }}
                                                                            @else
                                                                                Not Applicable
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                                <div class="block-head">
                                                                    HOD Final Review Attachment
                                                                </div>
                                                                <div class="border-table">
                                                                    <table>
                                                                        <tr class="table_bg">
                                                                            <th class="w-20">S.N.</th>
                                                                            <th class="w-60">File </th>
                                                                        </tr>
                                                                        @if ($data->hod_final_attachment)
                                                                            @foreach (json_decode($data->hod_final_attachment) as $key => $file)
                                                                                <tr>
                                                                                    <td class="w-20">
                                                                                        {{ $key + 1 }}</td>
                                                                                    <td class="w-20"><a
                                                                                            href="{{ asset('upload/' . $file) }}"
                                                                                            target="_blank"><b>{{ $file }}</b></a>
                                                                                    </td>
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
                                                        </div>

                                                        <div class="block">
                                                            <div class="block-head">
                                                                QA/CQA Closure Review
                                                            </div>
                                                            <div>
                                                                <table>
                                                                    <tr>
                                                                        <th class="w-20">QA/CQA Closure Review
                                                                            Comment</th>
                                                                        <td class="w-80">
                                                                            @if ($data->qa_cqa_qa_comments)
                                                                                {{ $data->qa_cqa_qa_comments }}
                                                                            @else
                                                                                Not Applicable
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                </table>

                                                                <div class="block-head">
                                                                    QA/CQA Closure Review Attachment
                                                                </div>
                                                                <div class="border-table">
                                                                    <table>
                                                                        <tr class="table_bg">
                                                                            <th class="w-20">S.N.</th>
                                                                            <th class="w-60">File </th>
                                                                        </tr>
                                                                        @if ($data->qa_closure_attachment)
                                                                            @foreach (json_decode($data->qa_closure_attachment) as $key => $file)
                                                                                <tr>
                                                                                    <td class="w-20">
                                                                                        {{ $key + 1 }}</td>
                                                                                    <td class="w-20"><a
                                                                                            href="{{ asset('upload/' . $file) }}"
                                                                                            target="_blank"><b>{{ $file }}</b></a>
                                                                                    </td>
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
                                                        </div>
                                                        <div class="block">
                                                            <div class="block-head">
                                                                QAH/CQAH Approval
                                                            </div>
                                                            <div>
                                                                <table>
                                                                    <tr>
                                                                        <th class="w-20">QAH/CQAH Approval Comment
                                                                        </th>
                                                                        <td class="w-80">
                                                                            @if ($data->qah_cq_comments)
                                                                                {{ $data->qah_cq_comments }}
                                                                            @else
                                                                                Not Applicable
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                </table>

                                                                <div class="block-head">
                                                                    QAH/CQAH Approval Attachment
                                                                </div>
                                                                <div class="border-table">
                                                                    <table>
                                                                        <tr class="table_bg">
                                                                            <th class="w-20">S.N.</th>
                                                                            <th class="w-60">File </th>
                                                                        </tr>
                                                                        @if ($data->qah_cq_attachment)
                                                                            @foreach (json_decode($data->qah_cq_attachment) as $key => $file)
                                                                                <tr>
                                                                                    <td class="w-20">
                                                                                        {{ $key + 1 }}</td>
                                                                                    <td class="w-20"><a
                                                                                            href="{{ asset('upload/' . $file) }}"
                                                                                            target="_blank"><b>{{ $file }}</b></a>
                                                                                    </td>
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
                                                        </div>
                                                    </div>


                                                    <div class="block">
                                                        <div class="block-head">
                                                            Activity Log
                                                        </div>
                                                        <table>
                                                            <tr>
                                                                <th class="w-20">Propose Plan By</th>
                                                                <td class="w-30">{{ $data->plan_proposed_by }}
                                                                </td>

                                                                <th class="w-20">Propose Plan On</th>
                                                                <td class="w-30">{{ $data->plan_proposed_on }}
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <th class="w-20">Comment</th>
                                                                <td class="w-80">{{ $data->comment }}</td>
                                                            </tr>

                                                            <tr>
                                                                <th class="w-20">QA/CQA Review Completed By</th>
                                                                <td class="w-30">
                                                                    {{ $data->qa_review_completed_by }}</td>

                                                                <th class="w-20">QA/CQA Review Completed On</th>
                                                                <td class="w-30">
                                                                    {{ $data->qa_review_completed_on }}</td>
                                                            </tr>

                                                            <tr>
                                                                <th class="w-20">Comment</th>
                                                                <td class="w-80">{{ $data->qa_comment }}</td>
                                                            </tr>

                                                            <tr>
                                                                <th class="w-20">HOD Review Completed By</th>
                                                                <td class="w-30">
                                                                    {{ $data->hod_review_completed_by }}</td>

                                                                <th class="w-20">HOD Review Completed On</th>
                                                                <td class="w-30">
                                                                    {{ $data->hod_review_completed_on }}</td>
                                                            </tr>

                                                            <tr>
                                                                <th class="w-20">Comment</th>
                                                                <td class="w-80">{{ $data->hod_comment }}</td>
                                                            </tr>

                                                            <tr>
                                                                <th class="w-20">Cancelled By</th>
                                                                <td class="w-30">{{ $data->cancelled_by }}</td>

                                                                <th class="w-20">Cancelled On</th>
                                                                <td class="w-30">{{ $data->cancelled_on }}</td>
                                                            </tr>

                                                            <tr>
                                                                <th class="w-20">Comment</th>
                                                                <td class="w-80">{{ $data->cancelled_on_comment }}
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <th class="w-20">Completed By</th>
                                                                <td class="w-30">{{ $data->completed_by }}</td>

                                                                <th class="w-20">Completed On</th>
                                                                <td class="w-30">{{ $data->completed_on }}</td>
                                                            </tr>

                                                            <tr>
                                                                <th class="w-20">Comment</th>
                                                                <td class="w-80">{{ $data->comment }}</td>
                                                            </tr>

                                                            <tr>
                                                                <th class="w-20">Approved By</th>
                                                                <td class="w-30">{{ $data->approved_by }}</td>

                                                                <th class="w-20">Approved On</th>
                                                                <td class="w-30">{{ $data->approved_on }}</td>
                                                            </tr>

                                                            <tr>
                                                                <th class="w-20">Comment</th>
                                                                <td class="w-80">{{ $data->approved_comment }}
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <th class="w-20">Completed By</th>
                                                                <td class="w-30">{{ $data->completed_by }}</td>

                                                                <th class="w-20">Completed On</th>
                                                                <td class="w-30">{{ $data->completed_on }}</td>
                                                            </tr>

                                                            <tr>
                                                                <th class="w-20">Comment</th>
                                                                <td class="w-80">{{ $data->com_comment }}</td>
                                                            </tr>

                                                            <tr>
                                                                <th class="w-20">HOD Final Review Completed By</th>
                                                                <td class="w-30">
                                                                    {{ $data->hod_final_review_completed_by }}</td>

                                                                <th class="w-20">HOD Final Review Completed On</th>
                                                                <td class="w-30">
                                                                    {{ $data->hod_final_review_completed_on }}</td>
                                                            </tr>

                                                            <tr>
                                                                <th class="w-20">Comment</th>
                                                                <td class="w-80">{{ $data->final_comment }}</td>
                                                            </tr>

                                                            <tr>
                                                                <th class="w-20">QA/CQA Closure Review Completed By
                                                                </th>
                                                                <td class="w-30">
                                                                    {{ $data->qa_closure_review_completed_by }}</td>

                                                                <th class="w-20">QA/CQA Closure Review Completed On
                                                                </th>
                                                                <td class="w-30">
                                                                    {{ $data->qa_closure_review_completed_on }}</td>
                                                            </tr>

                                                            <tr>
                                                                <th class="w-20">Comment</th>
                                                                <td class="w-80">{{ $data->qa_closure_comment }}
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <th class="w-20">QA/CQA Approval Completed By</th>
                                                                <td class="w-30">
                                                                    {{ $data->qah_approval_completed_by }}</td>

                                                                <th class="w-20">QA/CQA Approval Completed On</th>
                                                                <td class="w-30">
                                                                    {{ $data->qah_approval_completed_on }}</td>

                                                                <th class="w-20">Comment</th>
                                                                <td class="w-30">{{ $data->qah_comment }}</td>
                                                            </tr>

                                                        </table>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif

                                        @if (count($RiskManagement) > 0)
                                            @foreach ($RiskManagement as $data)
                                                <center>
                                                    <h3>RiskManagement Report</h3>
                                                </center>


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
                                                                    {{ Helpers::getDivisionName($data->division_id) }}/RA/{{ date('Y') }}/{{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}                </td>
                                                                    <th class="w-20">Site/Location Code</th>
                                                                    <td class="w-30">
                                                                    {{ Helpers::getDivisionName($data->division_id) }}
                                                                    </td>
                                                                </tr>
                                                                <tr>  {{ $data->created_at }} added by {{ $data->originator }}
                                                                    <th class="w-20">Initiator</th>
                                                                    <td class="w-30">{{ $data->originator }}</td>
                                                                    <th class="w-20">Date of Initiation</th>
                                                                    <td class="w-30">{{ Helpers::getdateFormat($data->created_at) }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <!-- <th class="w-20">Site/Location Code</th>
                                                                    <td class="w-30">@if($data->division_code){{ $data->division_code }} @else Not Applicable @endif</td> -->
                                                                    <th class="w-20">Assigned To</th>
                                                                    <td class="w-30">@if($data->assign_to){{ Helpers::getInitiatorName($data->assign_to) }} @else Not Applicable @endif</td>                   </tr>
                                                                <tr>
                                                                    <th class="w-20">Severity Level</th>
                                                                    <td class="w-30">@if($data->severity2_level){{ $data->severity2_level}} @else Not Applicable @endif</td>
                                                                    <th class="w-20">Due Date</th>
                                                                    <td class="w-80"> @if($data->due_date){{ $data->due_date }} @else Not Applicable @endif</td>
                                                                    {{--<th class="w-20">State/District</th>
                                                                    <td class="w-30">@if($data->state){{ $data->state }} @else Not Applicable @endif</td>--}}
                                                                </tr>
                                                                <tr>
                                                                    <th class="w-20">Initiator Group</th>
                                                                    <td class="w-30">@if($data->Initiator_Group){{ Helpers::getInitiatorGroupFullName($data->Initiator_Group) }} @else Not Applicable @endif</td>
                                                                    <th class="w-20">Initiator Group Code</th>
                                                                    <td class="w-30">@if($data->initiator_group_code){{ $data->initiator_group_code }} @else Not Applicable @endif</td>
                                                                </tr>
                                                                {{--<tr>--}}
                                                                    {{--  <th class="w-20">Team Members</th>
                                                                    <td class="w-30">@if($data->team_members){{ Helpers::getInitiatorName($data->team_members) }}@else Not Applicable @endif</td>  --}}
                                                                    
                                                                {{--</tr>--}}
                                                                <tr>
                                                                    <th class="w-20">Risk/Opportunity Description</th>
                                                                    <td class="w-80">@if($data->description){{ $data->description }} @else Not Applicable @endif</td>
                                                                </tr> 
                                                                {{--<tr> 
                                                                  
                                                                    <th class="w-20">Risk/Opportunity Comments</th>
                                                                    <td class="w-80">@if($data->comments){{ $data->comments }} @else Not Applicable @endif</td>
                                                                </tr>--}}
                                                                <tr>
                                                                 {{--  {{dd($data->departments)}}  --}}
                                                                     <th class="w-20">Department(s)</th>
                                                                     <td class="w-80">@if($data->departments){{  ($data->departments )}}@else Not Applicable @endif</td>
                                                                </tr>
                                                                   
                                                                    <tr>
                                                                    <th class="w-20"> Short Description</th>
                                                                    <td class="w-30">@if($data->short_description){{ $data->short_description }} @else Not Applicable @endif</td>
                                                                </tr>
                                                                <tr>
                                                                        <th class="w-20">Type</th>
                                                                        <td class="w-80">@if($data->type){{ $data->type }}@else Not Applicable @endif</td>
                                                                </tr>      
                                                                <tr>      
                                                                        <th class="w-20">Risk/Opportunity Comments</th>
                                                                        <td class="w-80">@if($data->comments){{ $data->comments }}@else Not Applicable @endif</td>
                                                                    
                                                                </tr>
                                                                <tr>
                                                                        <th class="w-20">Priority Level</th>
                                                                        <td class="w-80">@if($data->priority_level){{ $data->priority_level }}@else Not Applicable @endif</td>
                                                                        <th class="w-20">Source of Risk/Opportunity</th>
                                                                        <td class="w-80">@if($data->source_of_risk){{ $data->source_of_risk }}@else Not Applicable @endif</td>
                                                                    </tr>
                                                                
                                                            </table>
                                                        </div>
                                            
                                                        <div class="border-table">
                                                            <div class="block-head">
                                                                Initial Attachment
                                                            </div>
                                                            <table>
                                            
                                                                <tr class="table_bg">
                                                                    <th class="w-20">S.N.</th>
                                                                    <th class="w-60">Batch No</th>
                                                                </tr>
                                                                    @if($data->capa_attachment)
                                                                    @foreach(json_decode($data->capa_attachment) as $key => $file)
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
                                                    {{--</div>--}}
                                            
                                                      <br>
                                                       
                                                        <div class="block">
                                                            <div class="block-head">
                                                                Risk/Opportunity details
                                                            </div>
                                                            <table>
                                                                <tr>
                                                                        <th class="w-20">Department(s)</th>
                                                                        <td class="w-80">@if($data->departments2){{ ($data->departments2) }}@else Not Applicable @endif</td>
                                                                        <th class="w-20">Source of Risk</th>
                                                                        <td class="w-80">@if($data->source_of_risk){{ $data->source_of_risk }}@else Not Applicable @endif</td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="w-20">Site Name</th>
                                                                    <td class="w-30">{{ $data->site_name ?? 'Not Applicable' }}</td>
                                                                    
                                                                    <th class="w-20">Building</th>
                                                                    <td class="w-30">{{ $data->building ?? 'Not Applicable' }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="w-20">Floor</th>
                                                                    <td class="w-30">{{ $data->floor ?? 'Not Applicable' }}</td>
                                                                    
                                                                    <th class="w-20">Duration</th>
                                                                    <td class="w-30">{{ $data->duration ?? 'Not Applicable' }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="w-20">Hazard</th>
                                                                    <td class="w-30">{{ $data->hazard ?? 'Not Applicable' }}</td>
                                                                    
                                                                    <th class="w-20">Room</th>
                                                                    <td class="w-30">{{ $data->room ?? 'Not Applicable' }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="w-20">Regulatory Climate</th>
                                                                    <td class="w-30">{{ $data->regulatory_climate ?? 'Not Applicable' }}</td>
                                                                    
                                                                    <th class="w-20">Number of Employees</th>
                                                                    <td class="w-30">{{ $data->Number_of_employees ?? 'Not Applicable' }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="w-20">Room</th>
                                                                    <td class="w-30">{{ $data->room2 ?? 'Not Applicable' }}</td>
                                                                    
                                                                    <th class="w-20">Risk Management Strategy</th>
                                                                    <td class="w-30">{{ $data->risk_management_strategy ?? 'Not Applicable' }}</td>
                                                                </tr>
                                            
                                                               </table>
                                                            </div>
                                                        </div>
                                            
                                                       <div class="block">
                                                            <div class="block-head">
                                                                Work Group Assignment
                                                            </div>
                                                            <table>
                                                                <tr>
                                                                    <th class="w-20">Scheduled Start Date</th>
                                                                    <td class="w-30">@if($data->schedule_start_date1){{ Helpers::getdateFormat($data->schedule_start_date1) }}@else Not Applicable @endif</td>
                                                                    <th class="w-20">Scheduled End Date</th>
                                                                    <td class="w-30">@if($data->schedule_end_date1){{ Helpers::getdateFormat($data->schedule_end_date1) }}@else Not Applicable @endif</td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="w-50">Estimated Man-Hours</th>
                                                                    <td class="w-50">@if($data->estimated_man_hours){{ $data->estimated_man_hours }}@else Not Applicable @endif</td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="w-20">Estimated Cost</th>
                                                                    <td class="w-30">@if($data->estimated_cost){{ $data->estimated_cost }}@else Not Applicable @endif</td>
                                                                    <th class="w-20">Currency</th>
                                                                    <td class="w-30">@if($data->currency){{ $data->currency }}@else Not Applicable @endif</td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="w-20">Justification/Rationale</th>
                                                                    <td class="w-30">@if($data->justification){{ $data->justification }}@else Not Applicable @endif</td>
                                                                    
                                                                </tr>
                                                                
                                                            </table>
                                            
                                            
                                                         <div class="block-head">
                                                            Action Plan
                                                            </div>
                                                            <div class="border-table">
                                                                <table>
                                                                    <thead>
                                                                        <tr class="table_bg">
                                                                            <th>Row #</th>
                                                                            <th>Action</th>
                                                                            <th>Responsible</th>
                                                                            <th>Deadline</th>
                                                                            <th>Item Static</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @if ($action_plan)
                                                                            @php
                                                                                // Safely unserialize fields with fallback to empty arrays
                                                                                $actions = @unserialize($action_plan->action) ?: [];
                                                                                $responsibles = @unserialize($action_plan->responsible) ?: [];
                                                                                $deadlines = @unserialize($action_plan->deadline) ?: [];
                                                                                $itemStatics = @unserialize($action_plan->item_static) ?: [];
                                                                            @endphp
                                            
                                                                            @foreach ($actions as $key => $action)
                                                                                <tr>
                                                                                    <td>{{ $key + 1 }}</td>
                                                                                    <td>{{ $action }}</td>
                                                                                    
                                                                                    {{-- Responsible person --}}
                                                                                    <td>
                                                                                    {{ Helpers::getInitiatorName($responsibles[$key] ?? 'N/A') }}
                                                                                    </td>
                                                                                    
                                                                                    {{-- Deadline --}}
                                                                                    <td>{{ Helpers::getdateFormat($deadlines[$key]) ?? 'N/A' }}</td>
                                                                                    
                                                                                    {{-- Item Static --}}
                                                                                    <td>{{ $itemStatics[$key] ?? 'N/A' }}</td>
                                                                                </tr>
                                                                            @endforeach
                                                                        @else
                                                                            <tr>
                                                                                <td colspan="5">No data available.</td>
                                                                            </tr>
                                                                        @endif
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                            
                                            <br>
                                                            <div class="border-table">
                                                                <div class="block-head">
                                                                Work Group Attachments
                                                                </div>
                                                                <table>
                                            
                                                                    <tr class="table_bg">
                                                                        <th class="w-20">S.N.</th>
                                                                        <th class="w-60">Batch No</th>
                                                                    </tr>
                                                                        @if($data->reference)
                                                                        @foreach(json_decode($data->reference) as $key => $file)
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
                                                        </div>
                                                        <div class="block">
                                                            <div class="head">
                                                                <div class="block-head">
                                                                  Risk/Opportunity Analysis
                                                                </div>
                                                                <table>
                                                                  <tr>
                                                                    <th class="w-20">Root Cause Methodology</th>
                                                                    <td class="w-80">
                                                                    @if($data->root_cause_methodology)
                                                                     @php
                                                                         $method = explode(',',$data->root_cause_methodology);
                                            
                                                                     @endphp 
                                                                    @if(in_array('1',$method))
                                                                         Why-Why Chart,<br>
                                                                     @endif   
                                                                      @if (in_array('2',$method))
                                                                           Failure Mode and Efect Analysis,<br>
                                                                      @endif
                                                                     
                                                                     @if (in_array('3',$method))
                                                                         Fishbone or Ishikawa Diagram,<br>
                                                                     @endif
                                                                     @if (in_array('4',$method))
                                                                        Is/Is Not Analysis,<br>
                                                                     @endif
                                                                    
                                                                    @else Not Applicable 
                                                                    
                                                                    @endif
                                                                    
                                                                    </td>
                                                                    </tr>
                                                                    <tr>
                                                                    <th class="w-20">Root Cause Description</th>
                                                                    <td class="w-80">@if($data->root_cause_description){{ $data->root_cause_description}}@else Not Applicable @endif</td>
                                                                   </tr>
                                                                    <tr>
                                                                       <th class="w-20">Investigation Summary</th>
                                                                       <td class="w-80">@if($data->investigation_summary){{ $data->investigation_summary }}@else Not Applicable @endif</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="w-20">Severity Rate</th>
                                                                        <td class="w-80">
                                                                            <div>
                                                                                @if($data->severity_rate)
                                                                                    @switch($data->severity_rate)
                                                                                        @case(1)
                                                                                            Negligible
                                                                                            @break
                                                                                        @case(2)
                                                                                            Moderate
                                                                                            @break
                                                                                        @case(3)
                                                                                            Major
                                                                                            @break
                                                                                        @case(4)
                                                                                            Fatal
                                                                                            @break
                                                                                        @default
                                                                                            Not Applicable
                                                                                    @endswitch
                                                                                @else
                                                                                    Not Applicable
                                                                                @endif
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="w-20">Occurrence</th>
                                                                        <td class="w-80">
                                                                            <div>
                                                                                @if($data->occurrence)
                                                                                    @switch($data->occurrence)
                                                                                        @case(1)
                                                                                            Very Likely
                                                                                            @break
                                                                                        @case(2)
                                                                                            Likely
                                                                                            @break
                                                                                        @case(3)
                                                                                            Unlikely
                                                                                            @break
                                                                                        @case(4)
                                                                                            Rare
                                                                                            @break
                                                                                        @case('Extremely Unlikely')
                                                                                            Extremely Unlikely
                                                                                            @break
                                                                                        @default
                                                                                            Not Applicable
                                                                                    @endswitch
                                                                                @else
                                                                                    Not Applicable
                                                                                @endif
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="w-20">Detection</th>
                                                                        <td class="w-80">
                                                                            <div>
                                                                                @if($data->detection)
                                                                                    @switch($data->detection)
                                                                                        @case(1)
                                                                                            Very Likely
                                                                                            @break
                                                                                        @case(2)
                                                                                            Likely
                                                                                            @break
                                                                                        @case(3)
                                                                                            Unlikely
                                                                                            @break
                                                                                        @case(4)
                                                                                            Rare
                                                                                            @break
                                                                                        @case(5)
                                                                                            Impossible
                                                                                            @break
                                                                                        @default
                                                                                            Not Applicable
                                                                                    @endswitch
                                                                                @else
                                                                                    Not Applicable
                                                                                @endif
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="w-20">RPN</th>
                                                                        <td class="w-80">
                                                                            <div>
                                                                                @if($data->rpn)
                                                                                    {{ $data->rpn }}
                                                                                @else
                                                                                    Not Applicable
                                                                                @endif
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                            
                                            
                                            
                                                                <style>
                                                                .tableFMEA {
                                                                    width: 100%;
                                                                    border-collapse: collapse;
                                                                    font-size: 7px;
                                                                    table-layout: fixed; /* Ensures columns are evenly distributed */
                                                                }
                                            
                                                                .thFMEA,
                                                                .tdFMEA {
                                                                    border: 1px solid black;
                                                                    padding: 5px;
                                                                    word-wrap: break-word;
                                                                    text-align: center;
                                                                    vertical-align: middle;
                                                                    font-size: 6px; /* Apply the same font size for all cells */
                                                                }
                                            
                                                                /* Rotating specific headers */
                                                                .rotate {
                                                                    transform: rotate(-90deg);
                                                                    white-space: nowrap;
                                                                    width: 10px;
                                                                    height: 100px;
                                                                }
                                            
                                                                /* Ensure the "Traceability Document" column fits */
                                                                .tdFMEA:last-child,
                                                                .thFMEA:last-child {
                                                                    width: 80px; /* Allocate more space for "Traceability Document" */
                                                                }
                                            
                                                                /* Adjust for smaller screens to fit */
                                                                @media (max-width: 1200px) {
                                                                    .tdFMEA:last-child,
                                                                    .thFMEA:last-child {
                                                                        font-size: 6px;
                                                                        width: 70px; /* Shrink width further for smaller screens */
                                                                    }
                                                                }
                                            
                                                            </style>
                                            
                                            <div class="block-head">Failure Mode And Effect Analysis</div>
                                            <div class="table-responsive">
                                                <table class="tableFMEA">
                                                    <thead>
                                                        <tr class="table_bg">
                                                            <th class="thFMEA">Row #</th>
                                                            <th class="thFMEA">Risk Factor</th>
                                                            <th class="thFMEA">Risk Element</th>
                                                            <th class="thFMEA">Probable Cause</th>
                                                            <th class="thFMEA">Existing Risk Controls</th>
                                                            <th class="thFMEA">Initial Severity</th>
                                                            <th class="thFMEA">Initial Probability</th>
                                                            <th class="thFMEA">Initial Detectability</th>
                                                            <th class="thFMEA">Initial RPN</th>
                                                            <th class="thFMEA">Risk Acceptance</th>
                                                            <th class="thFMEA">Proposed Risk Control</th>
                                                            <th class="thFMEA">Residual Severity</th>
                                                            <th class="thFMEA">Residual Probability</th>
                                                            <th class="thFMEA">Residual Detectability</th>
                                                            <th class="thFMEA">Residual RPN</th>
                                                            <th class="thFMEA">Final Acceptance</th>
                                                            <th class="thFMEA">Mitigation Proposal</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if ($riskEffectAnalysis)
                                                            @php
                                                                // Safely unserialize and initialize all necessary fields
                                                                $riskFactors = @unserialize($riskEffectAnalysis->risk_factor) ?: [];
                                                                $riskElements = @unserialize($riskEffectAnalysis->risk_element) ?: [];
                                                                $problemCauses = @unserialize($riskEffectAnalysis->problem_cause) ?: [];
                                                                $existingRiskControls = @unserialize($riskEffectAnalysis->existing_risk_control) ?: [];
                                                                $initialSeverities = @unserialize($riskEffectAnalysis->initial_severity) ?: [];
                                                                $initialProbabilities = @unserialize($riskEffectAnalysis->initial_probability) ?: [];
                                                                $initialDetectabilities = @unserialize($riskEffectAnalysis->initial_detectability) ?: [];
                                                                $initialRPNs = @unserialize($riskEffectAnalysis->initial_rpn) ?: [];
                                                                $riskAcceptances = @unserialize($riskEffectAnalysis->risk_acceptance) ?: [];
                                                                $proposedRiskControls = @unserialize($riskEffectAnalysis->risk_control_measure) ?: [];
                                                                $residualSeverities = @unserialize($riskEffectAnalysis->residual_severity) ?: [];
                                                                $residualProbabilities = @unserialize($riskEffectAnalysis->residual_probability) ?: [];
                                                                $residualDetectabilities = @unserialize($riskEffectAnalysis->residual_detectability) ?: [];
                                                                $residualRPNs = @unserialize($riskEffectAnalysis->residual_rpn) ?: [];
                                                                $finalAcceptances = @unserialize($riskEffectAnalysis->risk_acceptance2) ?: [];
                                                                $mitigationProposals = @unserialize($riskEffectAnalysis->mitigation_proposal) ?: [];
                                                            @endphp
                                            
                                                            @foreach ($riskFactors as $key => $riskFactor)
                                                                <tr>
                                                                    <td class="tdFMEA">{{ $key + 1 }}</td>
                                                                    <td class="tdFMEA">{{ $riskFactor }}</td>
                                                                    <td class="tdFMEA">{{ $riskElements[$key] ?? '' }}</td>
                                                                    <td class="tdFMEA">{{ $problemCauses[$key] ?? '' }}</td>
                                                                    <td class="tdFMEA">{{ $existingRiskControls[$key] ?? '' }}</td>
                                                                    <td class="tdFMEA">{{ $initialSeverities[$key] ?? '' }}</td>
                                                                    <td class="tdFMEA">{{ $initialProbabilities[$key] ?? '' }}</td>
                                                                    <td class="tdFMEA">{{ $initialDetectabilities[$key] ?? '' }}</td>
                                                                    <td class="tdFMEA">{{ $initialRPNs[$key] ?? '' }}</td>
                                                                    <td class="tdFMEA">{{ $riskAcceptances[$key] ?? '' }}</td>
                                                                    <td class="tdFMEA">{{ $proposedRiskControls[$key] ?? '' }}</td>
                                                                    <td class="tdFMEA">{{ $residualSeverities[$key] ?? '' }}</td>
                                                                    <td class="tdFMEA">{{ $residualProbabilities[$key] ?? '' }}</td>
                                                                    <td class="tdFMEA">{{ $residualDetectabilities[$key] ?? '' }}</td>
                                                                    <td class="tdFMEA">{{ $residualRPNs[$key] ?? '' }}</td>
                                                                    <td class="tdFMEA">{{ $finalAcceptances[$key] ?? '' }}</td>
                                                                    <td class="tdFMEA">{{ $mitigationProposals[$key] ?? '' }}</td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <td colspan="17" class="tdFMEA">No data available.</td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                            
                                            
                                            
                                            
                                            
                                            
                                                                <div class="block-head">
                                                                    Fishbone or Ishikawa Diagram 
                                                                </div>
                                                                <table>
                                                                - <tr>
                                                                    <th class="w-20">Measurement</th>
                                                                    {{-- <td class="w-80">@if($riskgrdfishbone->measurement){{ $riskgrdfishbone->measurement }}@else Not Applicable @endif</td> --}}
                                                                         <td class="w-80">
                                                                        @php
                                                                            $measurement = unserialize($riskgrdfishbone->measurement);
                                                                        @endphp
                                                                        
                                                                        @if(is_array($measurement))
                                                                            @foreach($measurement as $value)
                                                                                {{ htmlspecialchars($value) }}
                                                                            @endforeach
                                                                        @elseif(is_string($measurement))
                                                                            {{ htmlspecialchars($measurement) }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                          </td>
                                                                    <th class="w-20">Materials</th>
                                                                    {{-- <td class="w-80">@if($riskgrdfishbone->materials){{ $riskgrdfishbone->materials }}@else Not Applicable @endif</td> --}}
                                                                         <td class="w-80">
                                                                        @php
                                                                            $materials = unserialize($riskgrdfishbone->materials);
                                                                        @endphp
                                                                        
                                                                        @if(is_array($materials))
                                                                            @foreach($materials as $value)
                                                                                {{ htmlspecialchars($value) }}
                                                                            @endforeach
                                                                        @elseif(is_string($materials))
                                                                            {{ htmlspecialchars($materials) }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                           </td>
                                                                    
                                                                </tr>
                                                                   <tr>
                                                                    <th class="w-20">Methods</th>
                                                                    {{-- <td class="w-80">@if($riskgrdfishbone->methods){{ $riskgrdfishbone->methods }}@else Not Applicable @endif</td> --}}
                                                                       <td class="w-80">
                                                                        @php
                                                                            $methods = unserialize($riskgrdfishbone->methods);
                                                                        @endphp
                                                                        
                                                                        @if(is_array($methods))
                                                                            @foreach($methods as $value)
                                                                                {{ htmlspecialchars($value) }}
                                                                            @endforeach
                                                                        @elseif(is_string($methods))
                                                                            {{ htmlspecialchars($methods) }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                       </td>
                                                                    <th class="w-20">Environment</th>
                                                                    {{-- <td class="w-80">@if($riskgrdfishbone->environment){{ $riskgrdfishbone->environment }}@else Not Applicable @endif</td> --}}
                                                                        <td class="w-80">
                                                                        @php
                                                                            $environment = unserialize($riskgrdfishbone->environment);
                                                                        @endphp
                                                                        
                                                                        @if(is_array($environment))
                                                                            @foreach($environment as $value)
                                                                                {{ htmlspecialchars($value) }}
                                                                            @endforeach
                                                                        @elseif(is_string($environment))
                                                                            {{ htmlspecialchars($environment) }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                        </td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="w-20">Manpower</th>
                                                                    {{-- <td class="w-80">@if($riskgrdfishbone->manpower){{ $riskgrdfishbone->manpower }}@else Not Applicable @endif</td> --}}
                                                                        <td class="w-80">
                                                                        @php
                                                                            $manpower = unserialize($riskgrdfishbone->manpower);
                                                                        @endphp
                                                                        
                                                                        @if(is_array($manpower))
                                                                            @foreach($manpower as $value)
                                                                                {{ htmlspecialchars($value) }}
                                                                            @endforeach
                                                                        @elseif(is_string($manpower))
                                                                            {{ htmlspecialchars($manpower) }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                       </td>
                                                                    <th class="w-20">Machine</th>
                                                                    {{-- <td class="w-80">@if($riskgrdfishbone->machine){{ $riskgrdfishbone->machine }}@else Not Applicable @endif</td> --}}
                                                                      <td class="w-80">
                                                                        @php
                                                                            $machine = unserialize($riskgrdfishbone->machine);
                                                                           // dd($machine);
                                                                        @endphp
                                                                        
                                                                        @if(is_array($machine))
                                                                            @foreach($machine as $value)
                                                                                {{ htmlspecialchars($value) }}
                                                                            @endforeach
                                                                        @elseif(is_string($machine))
                                                                            {{ htmlspecialchars($machine) }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                      </td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="w-20">Problem Statement1</th>
                                                                    <td class="w-80">
                                                                    @if($riskgrdfishbone->problem_statement)
                                                                    
                                                                    {{ $riskgrdfishbone->problem_statement }}
                                                                    @else 
                                                                    Not Applicable
                                                                     @endif</td>
                                                                  
                                                                </tr> 
                                                         </table>
                                                                    
                                                         <div class="block-head">
                                                            Why-Why Chart 
                                                        </div>
                                                        <table>
                                                        - <tr>
                                                            <th class="w-20">Problem Statement</th>
                                                            <td class="w-80">@if($riskgrdwhy_chart->why_problem_statement){{ $riskgrdwhy_chart->why_problem_statement }}@else Not Applicable @endif</td>
                                                            <th class="w-20">Why 1 </th>
                                                            {{-- <td class="w-80">@if($riskgrdwhy_chart->why_1){{ $riskgrdwhy_chart->why_1 }}@else Not Applicable @endif</td> --}}
                                                            <td class="w-80">
                                                                @php
                                                                    $why_1 = unserialize($riskgrdwhy_chart->why_1);
                                                                @endphp
                                                                
                                                                @if(is_array($why_1))
                                                                    @foreach($why_1 as $value)
                                                                        {{ htmlspecialchars($value) }}
                                                                    @endforeach
                                                                @elseif(is_string($why_1))
                                                                    {{ htmlspecialchars($why_1) }}
                                                                @else
                                                                    Not Applicable
                                                                @endif
                                                                  </td>
                                                        </tr>
                                                           <tr>
                                                            <th class="w-20">Why 2</th>
                                                            {{-- <td class="w-80">@if($riskgrdwhy_chart->why_2){{ $riskgrdwhy_chart->why_2 }}@else Not Applicable @endif</td> --}}
                                                            <td class="w-80">
                                                                @php
                                                                    $why_2 = unserialize($riskgrdwhy_chart->why_2);
                                                                @endphp
                                                                
                                                                @if(is_array($why_2))
                                                                    @foreach($why_2 as $value)
                                                                        {{ htmlspecialchars($value) }}
                                                                    @endforeach
                                                                @elseif(is_string($why_2))
                                                                    {{ htmlspecialchars($why_2) }}
                                                                @else
                                                                    Not Applicable
                                                                @endif
                                                                  </td>
                                                            <th class="w-20">Why 3</th>
                                                            {{-- <td class="w-80">@if($riskgrdwhy_chart->why_3){{ $riskgrdwhy_chart->why_3 }}@else Not Applicable @endif</td> --}}
                                                            <td class="w-80">
                                                                @php
                                                                    $why_3 = unserialize($riskgrdwhy_chart->why_3);
                                                                @endphp
                                                                
                                                                @if(is_array($why_3))
                                                                    @foreach($why_3 as $value)
                                                                        {{ htmlspecialchars($value) }}
                                                                    @endforeach
                                                                @elseif(is_string($why_3))
                                                                    {{ htmlspecialchars($why_3) }}
                                                                @else
                                                                    Not Applicable
                                                                @endif
                                                                  </td>
                                                        </tr>
                                                        <tr>
                                                            <th class="w-20">Why 4</th>
                                                            {{-- <td class="w-80">@if($riskgrdwhy_chart->why_4){{ $riskgrdwhy_chart->why_4 }}@else Not Applicable @endif</td> --}}
                                                            <td class="w-80">
                                                                @php
                                                                    $why_4 = unserialize($riskgrdwhy_chart->why_4);
                                                                @endphp
                                                                
                                                                @if(is_array($why_4))
                                                                    @foreach($why_4 as $value)
                                                                        {{ htmlspecialchars($value) }}
                                                                    @endforeach
                                                                @elseif(is_string($why_4))
                                                                    {{ htmlspecialchars($why_4) }}
                                                                @else
                                                                    Not Applicable
                                                                @endif
                                                                  </td>
                                                            <th class="w-20">Why5</th>
                                                            {{-- <td class="w-80">@if($riskgrdwhy_chart->why_4){{ $riskgrdwhy_chart->why_4 }}@else Not Applicable @endif</td> --}}
                                                            <td class="w-80">
                                                                @php
                                                                    $why_5 = unserialize($riskgrdwhy_chart->why_5);
                                                                @endphp
                                                                
                                                                @if(is_array($why_5))
                                                                    @foreach($why_5 as $value)
                                                                        {{ htmlspecialchars($value) }}
                                                                    @endforeach
                                                                @elseif(is_string($why_5))
                                                                    {{ htmlspecialchars($why_5) }}
                                                                @else
                                                                    Not Applicable
                                                                @endif
                                                                  </td>
                                                        </tr>
                                                        <tr>
                                                            <th class="w-20">Root Cause :	</th>
                                                            <td class="w-80">@if($riskgrdwhy_chart->why_root_cause){{ $riskgrdwhy_chart->why_root_cause }}@else Not Applicable @endif</td>
                                                          
                                                        </tr> 
                                                 </table>
                                            
                                            <div>     
                                                 <div class="block-head">
                                                    Is/Is Not Analysis
                                                </div>
                                            
                                                <table>
                                                <tr>
                                                <th class="w-20">What Will Be</th>
                                                <td class="w-80">@if($riskgrdwhat_who_where->what_will_be) {!! nl2br(e($riskgrdwhat_who_where->what_will_be)) !!} @else Not Applicable @endif</td>
                                                <th class="w-20">What Will Not Be</th>
                                                <td class="w-80">@if($riskgrdwhat_who_where->what_will_not_be) {!! nl2br(e($riskgrdwhat_who_where->what_will_not_be)) !!} @else Not Applicable @endif</td>
                                               
                                               </tr>
                                                <tr>
                                                <th class="w-20">What Will Rationale</th>
                                                <td class="w-80">@if($riskgrdwhat_who_where->what_rationable) {!! nl2br(e($riskgrdwhat_who_where->what_rationable)) !!} @else Not Applicable @endif</td>
                                                
                                                <th class="w-20">Where Will Be</th>
                                                <td class="w-80">@if($riskgrdwhat_who_where->where_will_be) {!! nl2br(e($riskgrdwhat_who_where->where_will_be)) !!} @else Not Applicable @endif</td>
                                                </tr>
                                                <tr>
                                            
                                                    <th class="w-20">Where Will Not Be</th>
                                                    <td class="w-80">@if($riskgrdwhat_who_where->where_will_not_be) {!! nl2br(e($riskgrdwhat_who_where->where_will_not_be)) !!} @else Not Applicable @endif</td>
                                                    <th class="w-20">Where Will Rationale</th>
                                                    <td class="w-80">@if($riskgrdwhat_who_where->where_rationable) {!! nl2br(e($riskgrdwhat_who_where->where_rationable)) !!} @else Not Applicable @endif</td>
                                                
                                                </tr>
                                                <tr>
                                                    <th class="w-20">When Will Be</th>
                                                    <td class="w-80">@if($riskgrdwhat_who_where->when_will_be) {!! nl2br(e($riskgrdwhat_who_where->when_will_be)) !!} @else Not Applicable @endif</td>
                                                    <th class="w-20">When Will Not Be</th>
                                                    <td class="w-80">@if($riskgrdwhat_who_where->when_will_not_be) {!! nl2br(e($riskgrdwhat_who_where->when_will_not_be)) !!} @else Not Applicable @endif</td>
                                                </tr>
                                                <tr> 
                                                    <th class="w-20">When Will Rationale</th>
                                                    <td class="w-80">@if($riskgrdwhat_who_where->when_rationable) {!! nl2br(e($riskgrdwhat_who_where->when_rationable)) !!} @else Not Applicable @endif</td>
                                               
                                                    <th class="w-20">Coverage Will Be</th>
                                                    <td class="w-80">@if($riskgrdwhat_who_where->coverage_will_be) {!! nl2br(e($riskgrdwhat_who_where->coverage_will_be)) !!} @else Not Applicable @endif</td>
                                                </tr>
                                                <tr>   
                                                   
                                                    <th class="w-20">Coverage Will Not Be</th>
                                                    <td class="w-80">@if($riskgrdwhat_who_where->coverage_will_not_be) {!! nl2br(e($riskgrdwhat_who_where->coverage_will_not_be)) !!} @else Not Applicable @endif</td>
                                                </tr>
                                                <tr>  
                                                    <th class="w-20">Coverage Will Rationale</th>
                                                    <td class="w-80">@if($riskgrdwhat_who_where->coverage_rationable) {!! nl2br(e($riskgrdwhat_who_where->coverage_rationable)) !!} @else Not Applicable @endif</td>
                                                </tr>
                                                <tr>
                                                    <th class="w-20">Who Will Be</th>
                                                    <td class="w-80">@if($riskgrdwhat_who_where->who_will_be) {!! nl2br(e($riskgrdwhat_who_where->who_will_be)) !!} @else Not Applicable @endif</td>
                                                    <th class="w-20">Who Will Not Be</th>
                                                    <td class="w-80">@if($riskgrdwhat_who_where->who_will_not_be) {!! nl2br(e($riskgrdwhat_who_where->who_will_not_be)) !!} @else Not Applicable @endif</td>
                                                </tr>
                                                <tr>   
                                                   
                                                    <th class="w-20">Who Will Rationale</th>
                                                    <td class="w-80">@if($riskgrdwhat_who_where->who_rationable) {!! nl2br(e($riskgrdwhat_who_where->who_rationable)) !!} @else Not Applicable @endif</td>
                                                </tr>
                                                
                                                </table>        
                                            
                                             </div>              
                                            
                                                        <div class="block">
                                                            <div class="head">
                                                                <div class="block-head">
                                                                 Residual Risk
                                                                </div>
                                                                <table>
                                                                <tr>
                                                                    <th class="w-20">Residual Risk</th>
                                                                    <td class="w-30">@if($data->residual_risk){{ $data->residual_risk }}@else Not Applicable @endif</td>
                                                                    <th class="w-20">Residual Risk Impact</th>
                                                                    <td class="w-30">
                                                                        @if($data->residual_risk_impact)
                                                                        
                                                                            @switch($data->residual_risk_impact)
                                                                                @case(1)
                                                                                    High
                                                                                    @break
                                                                                @case(2)
                                                                                    Low
                                                                                    @break
                                                                                @case(3)
                                                                                    Medium
                                                                                    @break
                                                                                @case(4)
                                                                                    None
                                                                                    @break
                                                                                @default
                                                                                    Not Applicable
                                                                            @endswitch
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="w-20">Residual Risk Probability</th>
                                                                    <td class="w-30">
                                                                        @if($data->residual_risk_probability)
                                                                            @switch($data->residual_risk_probability)
                                                                                @case(1)
                                                                                    High
                                                                                    @break
                                                                                @case(2)
                                                                                    Medium
                                                                                    @break
                                                                                @case(3)
                                                                                    Low
                                                                                    @break
                                                                                @default
                                                                                    Not Applicable
                                                                            @endswitch
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="w-20">Residual Detection</th>
                                                                    <td class="w-30">
                                                                    @if ($data->detection2)
                                                                        @switch($data->detection2)
                                                                            @case(5)
                                                                                Impossible
                                                                                @break
                                                                        @case(4)
                                                                                Rare
                                                                                @break
                                                                        @case(3)
                                                                                Unlikely
                                                                                @break
                                                                        @case(2)
                                                                                Likely
                                                                                @break
                                                                            @case(1)
                                                                                Very Likely
                                                                                @break
                                                                        
                                                                            @default
                                                                            Not Applicable     
                                                                        @endswitch
                                                                        @else
                                                                        Not Applicable  
                                                                    @endif
                                                                    </td>
                                                                    <th class="w-20">Residual RPN</th>
                                                                    <td class="w-30">@if($data->rpn2){{ $data->rpn2 }}@else Not Applicable @endif</td>
                                                                </tr>                  
                                                                <tr>
                                                                    <th class="w-20">Comments</th>
                                                                    <td class="w-30">@if($data->comments2){{ $data->comments2 }}@else Not Applicable @endif</td>
                                                                    
                                                                </tr>
                                                                
                                                              </table>
                                                            </div>
                                                        </div>
                                            
                                                        <div class="block">
                                                            <div class="head">
                                                                <div class="block-head">
                                                                Risk Analysis
                                                                </div>
                                                                <table>
                                                                <tr>
                                                                    <th class="w-20">Severity Rate</th>
                                                                    <td class="w-30">@if($data->severity_rate){{ $data->severity_rate }}@else Not Applicable @endif</td>
                                                                    <th class="w-20">Occurrence</th>
                                                                    <td class="w-30">
                                                                    @if ($data->occurrence)
                                                                        @switch($data->occurrence)
                                                                            @case(5)
                                                                                Impossible
                                                                                @break
                                                                        @case(4)
                                                                                Rare
                                                                                @break
                                                                        @case(3)
                                                                                Unlikely
                                                                                @break
                                                                        @case(2)
                                                                                Likely
                                                                                @break
                                                                            @case(1)
                                                                                Very Likely
                                                                                @break
                                                                        
                                                                            @default
                                                                            Not Applicable     
                                                                        @endswitch
                                                                        @else
                                                                        Not Applicable  
                                                                    @endif
                                                                    </td>
                                                                </tr>
                                                                
                                                                <tr>
                                                                    <th class="w-20">Detection</th>
                                                                    <td class="w-30">
                                                                    @if ($data->detection)
                                                                        @switch($data->detection)
                                                                            @case(5)
                                                                                Impossible
                                                                                @break
                                                                        @case(4)
                                                                                Rare
                                                                                @break
                                                                        @case(3)
                                                                                Unlikely
                                                                                @break
                                                                        @case(2)
                                                                                Likely
                                                                                @break
                                                                            @case(1)
                                                                                Very Likely
                                                                                @break
                                                                        
                                                                            @default
                                                                            Not Applicable     
                                                                        @endswitch
                                                                        @else
                                                                        Not Applicable  
                                                                    @endif
                                                                    </td>
                                                                    <th class="w-20">RPN</th>
                                                                    <td class="w-30">@if($data->rpn){{ $data->rpn }}@else Not Applicable @endif</td>
                                                                </tr>                  
                                                               
                                                                
                                                              </table>
                                                            </div>
                                                        </div>
                                            
                                                        
                                                        <div class="block">
                                                            <div class="head">
                                                                <div class="block-head">
                                                                  Risk Mitigation
                                                                </div>
                                                                <table>
                                                                <tr>
                                                                    <th class="w-20">Mitigation Required</th>
                                                                    <td class="w-30">@if($data->mitigation_required){{ $data->mitigation_required }}@else Not Applicable @endif</td>
                                                                    <th class="w-20">Mitigation Plan</th>
                                                                    <td class="w-30">@if($data->mitigation_plan){{ $data->mitigation_plan}}@else Not Applicable @endif</td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="w-20">Scheduled End Date</th>
                                                                    <td class="w-30">@if($data->mitigation_due_date){{ Helpers::getdateFormat($data->mitigation_due_date) }}@else Not Applicable @endif</td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="w-20">Status of Mitigation</th>
                                                                    <td class="w-30">@if($data->mitigation_status){{ $data->mitigation_status }}@else Not Applicable @endif</td>
                                                                    <th class="w-20">Mitigation Status Comments</th>
                                                                    <td class="w-30">@if($data->mitigation_status_comments){{ $data->mitigation_status_comments}}@else Not Applicable @endif</td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="w-20">Impact</th>
                                                                    <td class="w-30">@if($data->impact){{ $data->impact }}@else Not Applicable @endif</td>
                                                                    <th class="w-20">Criticality</th>
                                                                    <td class="w-30">@if($data->criticality){{ $data->criticality}}@else Not Applicable @endif</td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="w-20">Impact Analysis</th>
                                                                    <td class="w-80">@if($data->impact_analysis){{ $data->impact_analysis }}@else Not Applicable @endif</td>
                                                                    <th class="w-20">Risk Analysis</th>
                                                                    <td class="w-80">@if($data->risk_analysis){{ $data->risk_analysis}}@else Not Applicable @endif</td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="w-20">Reference Record</th>
                                                                    <td class="w-30">@if($data->refrence_record){{ Helpers::getDivisionName($data->refrence_record) }}/RA/{{ date('Y') }}/{{ Helpers::recordFormat($data->record) }}@else Not Applicable @endif</td>
                                                                    <th class="w-20">Due Date Extension Justification</th>
                                                                    <td class="w-80">@if($data->due_date_extension){{ $data->due_date_extension}}@else Not Applicable @endif</td>
                                                                </tr>
                                                              </table>
                                                            </div>
                                                        </div>
                                                        
                                            <div class="block-head">
                                                Mitigation Plan Details
                                            </div>
                                            
                                            <div class="border-table">
                                                <table>
                                                    <thead>
                                                        <tr class="table_bg">
                                                            <th>Row #</th>
                                                            <th>Mitigation Steps</th>
                                                            <th>Deadline</th>
                                                            <th>Responsible Person</th>
                                                            <th>Status</th>
                                                            <th>Remarks</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if ($mitigationData)
                                                            @php
                                                                // Safely unserialize fields with fallback to empty arrays
                                                                $mitigationSteps = @unserialize($mitigationData->mitigation_steps) ?: [];
                                                                $deadlines = @unserialize($mitigationData->deadline2) ?: [];
                                                                $responsiblePersons = @unserialize($mitigationData->responsible_person) ?: [];
                                                                $statuses = @unserialize($mitigationData->status) ?: [];
                                                                $remarks = @unserialize($mitigationData->remark) ?: [];
                                                            @endphp
                                            
                                                            @foreach ($mitigationSteps as $key => $step)
                                                                <tr>
                                                                    <td>{{ $key + 1 }}</td>
                                                                    <td>{{ $step }}</td>
                                                                    <td>{{ $deadlines[$key] ?? '' }}</td>
                                                                    <td>{{ Helpers::getInitiatorName($responsiblePersons[$key]) ?? 'N/A' }}</td>
                                                                    <td>{{ $statuses[$key] ?? '' }}</td>
                                                                    <td>{{ $remarks[$key] ?? '' }}</td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <td colspan="6">No data available.</td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                            
                                            
                                             <div class="block">
                                                            <div class="block-head">
                                                                Activity Log
                                                            </div>
                                                            <table>
                                                                <tr>
                                                                    <th class="w-20">Submit By</th>
                                                                    <td class="w-30">{{ $data->submitted_by }}</td>
                                                                    <th class="w-20">Submit On</th>
                                                                    <td class="w-30">{{ Helpers::getdateFormat($data->submitted_on) }}</td>
                                                                    <th class="w-20">Submit Comment</th>
                                                                    <td class="w-30">{{ $data->submitted_comment }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="w-20">Evaluation Complete By</th>
                                                                    <td class="w-30">{{ $data->evaluated_by }}</td>
                                                                    <th class="w-20">Evaluation Complete On</th>
                                                                    <td class="w-30">{{ Helpers::getdateFormat($data->evaluated_on) }}</td>
                                                                    <th class="w-20">Evaluation Complete Comment</th>
                                                                    <td class="w-30">{{ $data->evaluated_comment }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="w-20">Action Plan Complete By</th>
                                                                    <td class="w-30">{{ $data->plan_complete_by }}</td>
                                                                    <th class="w-20">Action Plan Complete On</th>
                                                                    <td class="w-30">{{ Helpers::getdateFormat($data->plan_complete_on) }}</td>
                                                                    <th class="w-20">Action Plan Complete Comment</th>
                                                                    <td class="w-30">{{ $data->plan_complete_on }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="w-20">Action Plan Approved By</th>
                                                                    <td class="w-30">{{ $data->plan_approved_by }}</td>
                                                                    <th class="w-20">Action Plan Approved On</th>
                                                                    <td class="w-30">{{ Helpers::getdateFormat($data->plan_approved_on) }}</td>
                                                                    <th class="w-20">Evaluated By</th>
                                                                    <td class="w-30">{{ $data->plan_approved_comment }}</td>
                                                                </tr>
                                                                
                                            
                                                                <tr>
                                                                    <th class="w-20">All Actions Completed By</th>
                                                                    <td class="w-30">{{ $data->actions_completed_by }}</td>
                                                                    <th class="w-20">All Actions Completed On</th>
                                                                    <td class="w-30">{{ Helpers::getdateFormat($data->actions_completed_on) }}</td>
                                                                    <th class="w-20">All Actions Completed Comment</th>
                                                                    <td class="w-30">{{ $data->actions_completed_comment }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="w-20">Residual Risk Evaluation Completed By</th>
                                                                    <td class="w-30">{{ $data->risk_analysis_completed_by }}</td>
                                                                    <th class="w-20">Residual Risk Evaluation Completed On</th>
                                                                    <td class="w-30">{{ Helpers::getdateFormat($data->risk_analysis_completed_on) }}</td>
                                                                    <th class="w-20">Residual Risk Evaluation Completed Comment</th>
                                                                    <td class="w-30">{{ $data->risk_analysis_completed_comment }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="w-20">Cancel By</th>
                                                                    <td class="w-30">{{ $data->cancelled_by }}</td>
                                                                    <th class="w-20">Cancel On</th>
                                                                    <td class="w-30">{{ Helpers::getdateFormat($data->cancelled_on) }}</td>
                                                                    <th class="w-20">Cancel Comment</th>
                                                                    <td class="w-30">{{ $data->cancelled_comment }}</td>
                                                                </tr>
                                                               
                                            
                                            
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            
                                            @endforeach
                                        @endif

                                        @if (count($InternalAudit) > 0)
                                            @foreach ($InternalAudit as $data)
                                                <center>
                                                    <h3>InternalAudit Report</h3>
                                                </center>
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
                                                                        @if ($data->record)
                                                                            {{ Helpers::divisionNameForQMS($data->division_id) }}/IA/{{ date('Y') }}/{{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                    <th class="w-20">Site/Location Code</th>
                                                                    <td class="w-30">
                                                                        @if ($data->division_code)
                                                                            {{ $data->division_code }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                                <tr> {{ $data->created_at }} added by {{ $data->originator }}
                                                                    <th class="w-20">Initiator</th>
                                                                    <td class="w-30">{{ $data->originator }}</td>
                                                                    <th class="w-20">Date of Initiation</th>
                                                                    <td class="w-30">{{ Helpers::getdateFormat($data->created_at) }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="w-20">Initiator Group</th>
                                                                    <td class="w-30">
                                                                        @if ($data->Initiator_Group){{Helpers::getInitiatorGroupFullName ($data->Initiator_Group) }}@else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                    <th class="w-20">Initiator Group Code</th>
                                                                    <td class="w-30">
                                                                        @if ($data->initiator_group_code)
                                                                            {{ $data->initiator_group_code }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="w-20">Due Date</th>
                                                                    <td class="w-30">
                                                                        @if ($data->due_date)
                                                                            {{ Helpers::getdateFormat($data->due_date) }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="w-20">Assigned to </th>
                                                                    <td class="w-30">
                                                                        @if ($data->assign_to)
                                                                            {{ Helpers::getInitiatorName($data->assign_to) }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                            
                                                                    <th class="w-20">Initiated Through</th>
                                                                    <td class="w-30">
                                                                        @if ($data->initiated_through)
                                                                            {{ $data->initiated_through }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="w-20">Short Description</th>
                                                                    <td class="w-30">
                                                                        @if ($data->short_description)
                                                                            {{ $data->short_description }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                    {{-- <th class="w-20">Severity Level </th>
                                                                    <td class="w-30">
                                                                        @if ($data->severity_level_form){{ $data->severity_level_form }}@else Not Applicable @endif
                                                                    </td> --}}
                                            
                                                                </tr>
                                            
                                                                <tr>
                                                                    <th class="w-20">Others</th>
                                                                    <td class="w-30">
                                                                        @if ($data->initiated_if_other)
                                                                            {{ $data->initiated_if_other }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="w-20">Scheduled audit date</th>
                                                                    <td class="w-30">
                                                                        @if ($data->sch_audit_start_date)
                                                                            {{ Helpers::getdateFormat($data->sch_audit_start_date) }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                    <th class="w-20">Auditee department Name</th>
                                                                    <td class="w-30">
                                                                        @if ($data->auditee_department)
                                                                            {{ Helpers::getFullDepartmentName($data->auditee_department) }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    {{-- <th class="w-20">Audit Category</th>
                                                                    <td class="w-30">
                                                                        @if ($data->Audit_Category)
                                                                            {{ $data->Audit_Category }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td> --}}
                                                                    <th class="w-20">If Other</th>
                                                                    <td class="w-30">
                                                                        @if ($data->if_other)
                                                                            {{ $data->if_other }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                            
                                                                </tr>
                                                                <tr>
                                                                    <th class="w-20">Description</th>
                                                                    <td class="w-30">
                                                                        @if ($data->initial_comments)
                                                                            {{ $data->initial_comments }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                    <th class="w-20">Type of Audit</th>
                                                                    <td class="w-30">
                                                                        @if ($data->audit_type)
                                                                            {{ $data->audit_type }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                    {{-- <th class="w-20">Audit start date</th>
                                                                    <td class="w-30">
                                                                        @if ($data->audit_start_date)
                                                                            {{ $data->audit_start_date }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td> --}}
                                            
                                                                </tr>
                                                                <tr>
                                                                    <th class="w-20">External Agencies</th>
                                                                    <td class="w-30">
                                                                        @if ($data->external_agencies)
                                                                            {{ $data->external_agencies }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                    <th class="w-20">Others</th>
                                                                    <td class="w-30">
                                                                        @if ($data->Others)
                                                                            {{ $data->Others }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                            
                                            
                                                                </tr>
                                            
                                                            </table>
                                            
                                            
                                                            <div class="border-table">
                                                                <div class="block-head">
                                                                    Initial Attachment
                                                                </div>
                                                                <table>
                                            
                                                                    <tr class="table_bg">
                                                                        <th class="w-20">S.N.</th>
                                                                        <th class="w-60">Batch No</th>
                                                                    </tr>
                                                                    @if ($data->inv_attachment)
                                                                        @foreach (json_decode($data->inv_attachment) as $key => $file)
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
                                                    </div>
                                                    
                                            
                                            
                                            
                                                    <div class="block">
                                                        <div class="head">
                                                            <div class="block-head">
                                                                Audit Planning
                                                            </div>
                                                            <table>
                                                                <tr>
                                                                    <th class="w-30">Audit Schedule Start Date</th>
                                                                    <td class="w-20">
                                                                        @if ($data->audit_schedule_start_date)
                                                                            {{Helpers::getdateFormat ($data->audit_schedule_start_date )}}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                    <th class="w-30">Audit Schedule End Date</th>
                                                                    <td class="w-20">
                                                                        @if ($data->audit_schedule_end_date)
                                                                            {{Helpers::getdateFormat( $data->audit_schedule_end_date) }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="w-20">Comments(If Any)</th>
                                                                    <td class="w-30">
                                                                        @if ($data->if_comments)
                                                                            @foreach (explode(',', $data->if_comments) as $Key => $value)
                                                                                <li>{{ $value }}</li>
                                                                            @endforeach
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                    <th class="w-20">Product/Material Name</th>
                                                                    <td class="w-80">
                                                                        @if ($data->material_name)
                                                                            @foreach (explode(',', $data->material_name) as $Key => $value)
                                                                                <li>{{ $value }}</li>
                                                                            @endforeach
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                            
                                                            </table>
                                                            <div class="block">
                                                                <div class="block-head">
                                                                    Audit Agenda
                                                                </div>
                                                    
                                                                <div class="border-table">
                                                                    <table>
                                                                        <tr class="table_bg">
                                                                            <th class="w-20">SR no.</th>
                                                                            <th>Area of Audit</th>
                                                                            <th>Start Date</th>
                                                                            <th>Start Time</th>
                                                                            <th>End Date</th>
                                                                            <th>End Time</th>
                                                                            <th>Auditor</th>
                                                                            <th>Auditee</th>
                                                                            <th>Remark</th>
                                                                        </tr>
                                                                        @if ($grid_data)
                                                                            @php
                                                                                // Getting the maximum number of entries in any of the arrays to loop through all rows
                                                                                $maxRows = max(
                                                                                    count($grid_data->area_of_audit ?? []),
                                                                                    count($grid_data->start_date ?? []),
                                                                                    count($grid_data->start_time ?? []),
                                                                                    count($grid_data->end_date ?? []),
                                                                                    count($grid_data->end_time ?? []),
                                                                                    count($grid_data->auditor ?? []),
                                                                                    count($grid_data->auditee ?? []),
                                                                                    count($grid_data->remark ?? []),
                                                                                );
                                                                            @endphp
                                                    
                                                                            @for ($i = 0; $i < $maxRows; $i++)
                                                                                <tr>
                                                                                    <td>{{ $i + 1 }}</td>
                                                                                    <td>{{ $grid_data->area_of_audit[$i] ?? 'Not Applicable' }}</td>
                                                                                    <td>{{ $grid_data->start_date[$i] ?? 'Not Applicable' }}</td>
                                                                                    <td>{{ $grid_data->start_time[$i] ?? 'Not Applicable' }}</td>
                                                                                    <td>{{ $grid_data->end_date[$i] ?? 'Not Applicable' }}</td>
                                                                                    <td>{{ $grid_data->end_time[$i] ?? 'Not Applicable' }}</td>
                                                                                    <td>{{ $grid_data->auditor[$i] ?? 'Not Applicable' }}</td>
                                                                                    <td>{{ $grid_data->auditee[$i] ?? 'Not Applicable' }}</td>
                                                                                    <td>{{ $grid_data->remark[$i] ?? 'Not Applicable' }}</td>
                                                                                </tr>
                                                                            @endfor
                                                                        @else
                                                                            <tr>
                                                                                <td colspan="9">No Data Available</td>
                                                                            </tr>
                                                                        @endif
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="block">
                                                        <div class="block-head">
                                                            Audit Preparation
                                                        </div>
                                                        <table>
                                                            <tr>
                                                                <th class="w-20">Lead Auditor</th>
                                                                <td class="w-30">
                                                                    @if ($data->lead_auditor)
                                                                        {{ Helpers::getInitiatorName($data->lead_auditor) }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                                <th class="w-20">External Auditor Details</th>
                                                                <td class="w-30">
                                                                    @if ($data->Auditor_Details)
                                                                        {{ $data->Auditor_Details }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th class="w-20">External Auditing Agencys</th>
                                                                <td class="w-30">
                                                                    @if ($data->External_Auditing_Agency)
                                                                        {{ $data->External_Auditing_Agency }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                                <th class="w-20">Relevant Guidelines /Industry Standards</th>
                                                                <td class="w-30">
                                                                    @if ($data->Relevant_Guideline)
                                                                        {{ $data->Relevant_Guideline }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th class="w-20">QA Comments</th>
                                                                <td class="w-30">
                                                                    @if ($data->QA_Comments)
                                                                        {{ $data->QA_Comments }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                            </tr>
                                            
                                                            <tr>
                                                                <th class="w-20">Audit team</th>
                                                                <td class="w-30">
                                                                    @if ($data->Audit_team)
                                                                        @foreach (explode(',', $data->Audit_team) as $Key => $value)
                                                                            <li>{{ Helpers::getInitiatorName($value) }}</li>
                                                                        @endforeach
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                                <th class="w-20">Auditee</th>
                                                                <td class="w-30">
                                                                    @if ($data->Auditee)
                                                                        @foreach (explode(',', $data->Auditee) as $Key => $value)
                                                                            <li>{{ Helpers::getInitiatorName($value) }}</li>
                                                                        @endforeach
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                            
                                                            </tr>
                                                            <tr>
                                                                <th class="w-20">Comments</th>
                                                                <td class="w-30">
                                                                    @if ($data->Comments)
                                                                        {{ $data->Comments }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                                
                                                            </tr>
                                                            <tr>
                                                                <th class="w-20">Supplier/Vendor/Manufacturer Site</th>
                                                                <td class="w-30">
                                                                    @if ($data->Supplier_Site)
                                                                        {{ $data->Supplier_Site }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                                <th class="w-20">Supplier/Vendor/Manufacturer Details</th>
                                                                <td class="w-30">
                                                                    @if ($data->Supplier_Details)
                                                                        {{ $data->Supplier_Details }}
                                                                    @else
                                                                        Not Applicable
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <div class="border-table">
                                                            <div class="block-head">
                                                                File Attachment
                                                            </div>
                                                            <table>
                                            
                                                                <tr class="table_bg">
                                                                    <th class="w-20">S.N.</th>
                                                                    <th class="w-60">Batch No</th>
                                                                </tr>
                                                                @if ($data->file_attachment)
                                                                    @foreach (json_decode($data->file_attachment) as $key => $file)
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
                                                        <div class="border-table">
                                                            <div class="block-head">
                                                                Guideline Attachment
                                            
                                                            </div>
                                                            <table>
                                            
                                                                <tr class="table_bg">
                                                                    <th class="w-20">S.N.</th>
                                                                    <th class="w-60">Batch No</th>
                                                                </tr>
                                                                @if ($data->file_attachment_guideline)
                                                                    @foreach (json_decode($data->file_attachment_guideline) as $key => $file)
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
                                                        <div class="head">
                                                            <div class="block-head">
                                                                Audit Execution</div>
                                                            <table>
                                            
                                                                <tr>
                                                                    <th class="w-20">Audit Start Date</th>
                                                                    <td class="w-30">
                                                                        <div>
                                                                            @if ($data->audit_start_date)
                                                                                {{ Helpers::getdateFormat($data->audit_start_date) }}
                                                                            @else
                                                                                Not Applicable
                                                                            @endif
                                                                        </div>
                                                                    </td>
                                                                    <th class="w-20">Audit End Date</th>
                                                                    <td class="w-30">
                                                                        <div>
                                                                            @if ($data->audit_end_date)
                                                                                {{ Helpers::getdateFormat($data->audit_end_date) }}
                                                                            @else
                                                                                Not Applicable
                                                                            @endif
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                            
                                                                <tr>
                                                                    <th class="w-20">Audit Comments</th>
                                                                    <td class="w-80">
                                                                        @if ($data->Audit_Comments2)
                                                                            {{ $data->Audit_Comments2 }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                               
                                                            </table>
                                                        </div>
                                                    </div>
                                                   
                                            
                                            
                                            
                                            
                                                    <div class="border-table">
                                                        <div class="block-head">
                                                            Audit  Attachment</div>
                                                        <table>
                                            
                                                            <tr class="table_bg">
                                                                <th class="w-20">S.N.</th>
                                                                <th class="w-60">Batch No</th>
                                                            </tr>
                                                            @if ($data->Audit_file)
                                                                @foreach (json_decode($data->Audit_file) as $key => $file)
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
                                                            Audit Response & Closer
                                                        </div>
                                                        <table>
                                                            <tr>
                                                                <th class="w-20">Remark</th>
                                                                <td class="w-30">
                                                                    <div>
                                                                        @if ($data->Remarks)
                                                                            {{ $data->Remarks }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                </td>
                                            
                                                                <th class="w-20">Reference Record</th>
                                                                <td class="w-30">
                                                                    <div>
                                                                        @if ($data->refrence_record)
                                                                            {{ Helpers::getDivisionName($data->refrence_record) }}/IA/{{ date('Y') }}/{{ Helpers::recordFormat($data->record) }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th class="w-20">Audit Comments
                                                                </th>
                                                                <td class="w-80">
                                                                    <div>
                                                                        @if ($data->Audit_Comments2)
                                                                            {{ $data->Audit_Comments2 }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </div>
                                                                </td>
                                                                <th class="w-20">Due Date Extension Justification</th>
                                                                <td class="w-80">
                                                                    <div>
                                                                        @if ($data->due_date_extension)
                                                                            {{ $data->due_date_extension }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </div>
                                                                </td>
                                                            </tr>
                                            
                                            
                                            
                                                        </table>
                                            
                                            
                                                       
                                            
                                                        <div class="border-table">
                                                            <div class="block-head">
                                                                Report Attachment
                                                            </div>
                                                            <table>
                                            
                                                                <tr class="table_bg">
                                                                    <th class="w-20">S.N.</th>
                                                                    <th class="w-60">Batch No</th>
                                                                </tr>
                                                                @if ($data->report_file)
                                                                    @foreach (json_decode($data->report_file) as $key => $file)
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
                                                        <div class="border-table">
                                                            <div class="block-head">
                                                                Audit Attachments
                                                            </div>
                                                            <table>
                                            
                                                                <tr class="table_bg">
                                                                    <th class="w-20">S.N.</th>
                                                                    <th class="w-60">Batch No</th>
                                                                </tr>
                                                                @if ($data->myfile)
                                                                    @foreach (json_decode($data->myfile) as $key => $file)
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
                                                   
                                            
                                                </div>
                                                </div>
                                                </div>
                                            
                                            
                                            
                                            
                                                </div>
                                            
                                            
                                                @php
                                                    $questions_packing = [
                                                        'Is access to the facility restricted?',
                                                        'Is the dispensing area cleaned as per SOP?',
                                                        'Check the status label of area and equipment.',
                                                        'Are all raw materials carry proper label?',
                                                        'Standard operating procedure for dispensing of raw material is displayed?',
                                                        'All the person involve in dispensing having proper gowning?',
                                                        'Where you keep the materials after dispensing?',
                                                        'Is there any log book for keeping the record of dispensing?',
                                                        'Have you any standard practice to cross check the approved status of raw materials before dispensing?',
                                                        'Are all balances calibrated which are to be use for dispensing?',
                                                        'Is the pressure differential of RLAF is within acceptance limit? What is the limit? _______',
                                                        'Is the pressure differential of the area is within acceptance limit? Check the pressure differential__________',
                                                        'Is there any record for room temperature & relative humidity? Check the temperature _____°C & RH _____%',
                                                    ];
                                            
                                                    $questions_documentation = [
                                                        'Is status labels displayed on all equipments?',
                                                        'Equipment cleanliness, check few equipments.',
                                                        'Are machine surfaces that contact materials or finished goods, non–reactive, non-absorptive and non – additive so as not to affect the product?',
                                                        'Are there data to show that cleaning procedures for non-dedicated equipment are adequate to remove the previous materials? For active ingredients, have these procedures been validated?',
                                                        'Do you have written procedures for the safe and correct use of cleaning and sanitizing agents? What are the sanitizing agents used in this plant?',
                                                        'Are there data to show that the residues left by the cleaning and/or sanitizing agent are within acceptable limits when cleaning is performed in accordance with the approved method?',
                                                        'Do you have written procedures that describe the sufficient details of the cleaning schedule, methods, equipment and material? Check for procedure compliance',
                                                        'Are there written instructions describing how to use in-process data to control the process?',
                                                        'Are all piece of equipment clearly identified with easily visible markings? Check the equipment nos. corresponds to an entry in a log book',
                                                        'Is equipment inspected immediately prior to use?',
                                                        'Do cleaning instructions include disassembly and drainage procedure, if required to ensure that no cleaning solutions or rinse remains in the equipment?',
                                                        'Has a written schedule been established and is it followed for cleaning of equipment?',
                                                        'Are seams on product-contact surfaces smooth and properly maintained to minimize accumulation of product, dirt, and organic matter and to avoid growth of microorganisms?',
                                                        'Is clean equipment clearly identified as “cleaned” with a cleaning date shown on the equipment tag? Check for few equipments.',
                                                        'Is equipment cleaned promptly after use?',
                                                        'Is there proper storage of cleaned equipment so as to prevent contamination?',
                                                        'Is there adequate system to assure that unclean equipment and utensils are not used (e.g., labeling with clean status)?',
                                                        'Is sewage, trash and other reuse disposed off in a safe and sanitary manner ( and with sufficient frequency)',
                                                        'Are written records maintained on equipment cleaning, sanitizing and maintenance on or near each piece of equipment? Check 2 equipment records.',
                                                        'Are all weighing and measuring performed by one qualified person and checked by a second person Check the weighing balance record.',
                                                        'Are the sieves & screen kept in proper place with proper label?',
                                                        'Is the pressure differential of every particular area are within limit?',
                                                        'All the person working in granulation area having proper gowning?',
                                                        'Is Inventory record of sieve, screen, rubber sleeve, FBD bag, etc. maintained?',
                                                        'Check the FBD bags for three products, and their utilization records.',
                                                        'Have you any SOP regarding Hold time of material during staging?',
                                                        'Is there a written procedure specifying the frequency of inspection and replacement for air filters?',
                                                        'Are written operating procedures available for each equipment used in the manufacturing, processing? Check for SOP compliance. Check the list of equipment and equipment details.',
                                                        'Does each equipment have written instructions for maintenance that includes a schedule for maintenance?',
                                                        'Does the process control address all issues to ensure identity, strength, quality and purity of product?',
                                                        'Check the calibration labels for instrument calibration status.',
                                                        'Temperature & RH record log book is available for each staging area.',
                                                        'Check for area activity record.',
                                                        'Check for equipment usage record.',
                                                        'Check for general equipment details and accessory details.',
                                                        'Check for man & material movement in the area.',
                                                        'Air handling system qualification , cleaning details and PAO test reports.',
                                                        'Check for purified water hose pipe status and water hold up.',
                                                        'Check for the status labeling in the area and material randomly.',
                                                        'Check the in-process equipments cleaning status & records.',
                                                        'Are any unplanned process changes (process excursions) documented in the batch record?',
                                                        'If the product is blended, are there blending parameters and/or homogeneity specifications?',
                                                        'Are materials and equipment clearly labeled as to identity and, if appropriate, stage of manufacture?',
                                                        'Is there is an preventive maintenance program for all equipment and status of it.',
                                                    ];
                                            
                                                    $questions_documentation_table = [
                                                        'Do records have doer & checker signatures? Check the timings, date and yield etc. in the batch manufacturing record.',
                                                        'Is each batch assigned a distinctive code, so that material can be traced through manufacturing and distribution? Check for In process analytical reports.',
                                                        'Is the batch record is on line up to the current stage of a process?',
                                                        'In process carried out as per the written instruction describe in batch record?',
                                                        'Is there any area cleaning record available?',
                                                        'Current version of SOP’s is available in respective areas?',
                                                    ];
                                                @endphp
                                            
                                            
                                            
                                                <div class="inner-block">
                                                    <div class="content-table">
                                                        <!-- <div class="border-table"> -->
                                                        <div class="block-head">
                                                            Checklist - Production (Tablet Dispensing & Tablet Granulation) </div>
                                                        <div>
                                                            @php
                                                                $checklists = [
                                                                    [
                                                                        'title' => 'STAGE 1 : DISPENSING',
                                                                        'questions' => $questions_packing,
                                                                        'prefix' => 1,
                                                                    ],
                                                                    [
                                                                        'title' => 'Stage -02 Granulation',
                                                                        'questions' => $questions_documentation,
                                                                        'prefix' => 2,
                                                                    ],
                                                                    [
                                                                        'title' => 'Stage -03 Documentation',
                                                                        'questions' => $questions_documentation_table,
                                                                        'prefix' => 3,
                                                                    ],
                                                                ];
                                                            @endphp
                                            
                                                            @foreach ($checklists as $checklist)
                                                                <div class="block"
                                                                    style="color: #4274da; display: inline-block; border-bottom: 1px solid #4274da;">
                                                                    {{ $checklist['title'] }}
                                                                </div>
                                                                <table class="table table-bordered">
                                                                    <thead>
                                                                        <tr>
                                                                            <th style="width: 5%;">Sr. No.</th>
                                                                            <th style="width: 40%;">Question</th>
                                                                            <th style="width: 20%;">Response</th>
                                                                            <th>Remarks</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach ($checklist['questions'] as $index => $question)
                                                                            @php
                                                                                $response = $data->{'response_' . ($index + 1)};
                                                                                $remark = $data->{'remark_' . ($index + 1)};
                                                                            @endphp
                                            
                                                                            <!-- Check if either response or remark is not empty -->
                                                                            @if ($response || $remark)
                                                                                <tr>
                                                                                    <td class="flex text-center">{{ $checklist['prefix'] . '.' . ($index + 1) }}
                                                                                    </td>
                                                                                    <td>{{ $question }}</td>
                                                                                    <td>
                                                                                        <div
                                                                                            style="display: flex; justify-content: center; align-items: center; margin: 5%; gap: 5px;">
                                                                                            {{ $response }}
                                                                                        </div>
                                                                                    </td>
                                                                                    <td style="vertical-align: middle;">
                                                                                        <div style="margin: auto; display: flex; justify-content: center;">
                                                                                            {{ $remark }}
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                            @endif
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            @endforeach
                                                        </div>
                                                        <!-- </div> -->
                                                    </div>
                                                </div>
                                            
                                                @php
                                                    $questions_packing = [
                                                        'Check for area activity record.',
                                                        'Check for equipment usage record.',
                                                        'Check for general equipment details and accessory details.',
                                                        'Check for man & material movement in the area.',
                                                        'Air handling system qualification, cleaning details and PAO test reports.',
                                                        'Check for purified water hose pipe status and water hold up.',
                                                        'Check for the status labeling in the area and, material randomly.',
                                                        'Check the in-process equipments cleaning status & records.',
                                                        'Are any unplanned process changes (process excursions) documented in the batch record?',
                                                        'Are materials and equipment clearly labeled as to identity and, if appropriate, stage of manufacture?',
                                                        'Is there a preventive maintenance program for all equipment and status of it?',
                                                        'Status label of area & equipment available?',
                                                        'Have you any proper storage area for primary and secondary packing material?',
                                                        'Do you have proper segregation system for keeping product/batch separately?',
                                                        'Is there proper covering of printed foil roll with poly bag?',
                                                        'Stereo impression record available? Check the record for any 2 batches.',
                                                        'Where you keep the rejected strips / blisters / containers / cartons?',
                                                        'Is there any standard practice for destruction of printed aluminum foil & printed cartons?',
                                                        'Is there a written procedure for cleaning the packaging area after one packaging operation, and cleaning before the next operation, especially if the area is used for packaging different materials?',
                                                        'Have you any standard procedure for removal of scrap?',
                                                    ];
                                            
                                                    $questions_documentation = [
                                                        'Do records have doer & checker signatures? Check the timings, date and yield etc in the batch packing record.',
                                                        'Is each batch assigned a distinctive code, so that material can be traced through manufacturing and distribution? Check for In process analytical reports.',
                                                        'Is the batch record is on line up to the current stage of a process?',
                                                        'In process carried out as per the written instruction describe in batch record?',
                                                        'Is there any area cleaning record available for all individual areas?',
                                                        "Current version of SOP's is available in respective areas?",
                                                    ];
                                                @endphp
                                                @if (!empty($data->checklist3))
                                            
                                                    <div class="inner-block">
                                                        <div class="content-table">
                                                            <!-- <div class="border-table"> -->
                                                            <div class="block-head">
                                                                Checklist - Tablet/Capsule Packing
                                                            </div>
                                                            <div>
                                                                @php
                                                                    $checklists = [
                                                                        [
                                                                            'title' => 'STAGE 1 : PACKING',
                                                                            'questions' => $questions_packing,
                                                                            'prefix' => 1,
                                                                        ],
                                                                        [
                                                                            'title' => 'STAGE 2: DOCUMENTATION',
                                                                            'questions' => $questions_documentation,
                                                                            'prefix' => 2,
                                                                        ],
                                                                    ];
                                                                @endphp
                                            
                                                                @foreach ($checklists as $checklist)
                                                                    <div class="block"
                                                                        style="color: #4274da; display: inline-block; border-bottom: 1px solid #4274da;">
                                                                        {{ $checklist['title'] }}
                                                                    </div>
                                                                    <table class="table table-bordered">
                                                                        <thead>
                                                                            <tr>
                                                                                <th style="width: 5%;">Sr. No.</th>
                                                                                <th style="width: 40%;">Question</th>
                                                                                <th style="width: 20%;">Response</th>
                                                                                <th>Remarks</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach ($checklist['questions'] as $index => $question)
                                                                                @php
                                                                                    $response = $checklist3->{'tablet_capsule_packing_' . ($index + 1)};
                                                                                    $remark = $checklist3->{'tablet_capsule_packing_remark_' . ($index + 1)};
                                                                                @endphp
                                            
                                                                                <!-- Check if either response or remark is not empty -->
                                                                                @if ($response || $remark)
                                                                                    <tr>
                                                                                        <td class="flex text-center">
                                                                                            {{ $checklist['prefix'] . '.' . ($index + 1) }}</td>
                                                                                        <td>{{ $question }}</td>
                                                                                        <td>
                                                                                            <div
                                                                                                style="display: flex; justify-content: center; align-items: center; margin: 5%; gap: 5px;">
                                                                                                {{ $response }}
                                                                                            </div>
                                                                                        </td>
                                                                                        <td style="vertical-align: middle;">
                                                                                            <div style="margin: auto; display: flex; justify-content: center;">
                                                                                                {{ $remark }}
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr>
                                                                                @endif
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                @endforeach
                                                            </div>
                                                            <!-- </div> -->
                                                        </div>
                                                    </div>
                                                @endif
                                            
                                                @php
                                                    $questions = [
                                                        'Is status labels displayed on all equipments / machines?',
                                                        '1.2Equipment cleanliness, check few equipments.',
                                                        'Are machine surfaces that contact materials or finished goods, non–reactive, non-absorptive and non – additive so as not to affect the product?',
                                                        'Are there data to show that cleaning procedures for non-dedicated equipment are adequate to remove the previous materials? For active ingredients, have these procedures been validated?',
                                                        'Do you have written procedures for the safe and correct use of cleaning and sanitizing agents? What are the sanitizing agents used in this plant?',
                                                        'Are there data to show that the residues left by the cleaning and/or sanitizing agent are within acceptable limits when cleaning is performed in accordance with the approved method?',
                                                        'Do you have written procedures that describe the sufficient details of the cleaning schedule, methods, equipment and material? Check for procedure compliance',
                                                        'Are there written instructions describing how to use in-process data to control the process?',
                                                        'Are all piece of equipment clearly identified with easily visible markings? Check the equipment nos. corresponds to an entry in a log book.',
                                                        'Is equipment inspected immediately prior to use?',
                                                        'Do cleaning instructions include disassembly and drainage procedure, if required to ensure that no cleaning solutions or rinse remains in the equipment?',
                                                        'Has a written schedule been established and is it followed for cleaning of equipment?',
                                                        'Are seams on product-contact surfaces smooth and properly maintained to minimize accumulation of product, dirt, and organic matter and to avoid growth of microorganisms?',
                                                        'Is clean equipment clearly identified as “cleaned” with a cleaning date shown on the equipment tag? Check for few equipments',
                                                        'Is equipment cleaned promptly after use?',
                                                        'Is there proper storage of cleaned equipment so as to prevent contamination?	',
                                                        'Is sewage, trash and other reuse disposed off in a safe and sanitary manner (and with sufficient frequency)',
                                                        'Are written records maintained on equipment cleaning, sanitizing and maintenance on or near each piece of equipment? Check 2 equipment records.',
                                                        'Are all weighing and measuring performed by one qualified person and checked by a second person',
                                                        'All the person working in manufacturing area having proper gowning?',
                                                        'Have you any SOP regarding Hold time of material during staging?',
                                                        'Is there a written procedure specifying the frequency of inspection and replacement for air filters?',
                                                        'Check for area activity record',
                                                        'Check for equipment usage record',
                                                        'Check for general equipment details and accessory details.',
                                                        'Check for man & material movement in the area',
                                                        'Air handling system qualification, cleaning details and PAO test reports',
                                                        'Check for the status labeling in the area and, material randomly',
                                                        'Check the in-process equipments cleaning status & records.',
                                                        'Are any unplanned process changes (process excursions) documented in the batch record?',
                                                        'Status label of area & equipment available?',
                                                        'Have you any proper storage area for primary and secondary packing material?',
                                                        'Do you have proper segregation system for keeping product/batch separately?',
                                                        'Stereo impression record available? Check the record for any 2 batches.',
                                                        'Where you keep the rejected ampoule / cartons?',
                                                        'Is there any standard practice for destruction of printed ampoule label & printed cartons?',
                                                        'Is there a written procedure for clearing the packaging area after one packaging operation, and cleaning before the next operation, especially if the area is used for packaging different materials?',
                                                        'Is there any procedure for operation and cleaning of ampoule label machine, verify the record',
                                                        'Is there any procedure for operation and cleaning of ampoule blister machine, verify the record.',
                                                        'Have you any standard procedure for removal of scrap?',
                                                        'Is there any procedure to cross verify the dispensed packaging material before starting the packaging.',
                                                    ];
                                            
                                                    $questions_documentation = [
                                                        'Do records have doer & checker signatures? Check the timings, date and yield etc in the batch production record.',
                                                        'Is each batch assigned a distinctive code, so that material can be traced through manufacturing and distribution? Check for In process analytical reports',
                                                        'Is the batch record is on line up to the current stage of a process?',
                                                        'In process carried out as per the written instruction describe in batch record?',
                                                        'Is there any punch inventory and punch utilization record?	',
                                                        'Is there any area cleaning record available for all individual areas?',
                                                        'Current version of SOP’s is available in respective areas?',
                                                    ];
                                                @endphp
                                                @if (!empty($data->checklist3))
                                            
                                                    <div class="inner-block">
                                                        <div class="content-table">
                                                            <!-- <div class="border-table"> -->
                                                            <div class="block-head">
                                                                Checklist - Production (Tablet Compression) </div>
                                                            <div>
                                                                @php
                                                                    $checklists = [
                                                                        [
                                                                            'title' => 'STAGE 1: COMPRESSION ',
                                                                            'questions' => $questions,
                                                                            'prefix' => 1,
                                                                        ],
                                                                        [
                                                                            'title' => 'STAGE 2: DOCUMENTATION',
                                                                            'questions' => $questions_documentation,
                                                                            'prefix' => 2,
                                                                        ],
                                                                    ];
                                                                @endphp
                                            
                                                                @foreach ($checklists as $checklist)
                                                                    <div class="block"
                                                                        style="color: #4274da; display: inline-block; border-bottom: 1px solid #4274da;">
                                                                        {{ $checklist['title'] }}
                                                                    </div>
                                                                    <table class="table table-bordered">
                                                                        <thead>
                                                                            <tr>
                                                                                <th style="width: 5%;">Sr. No.</th>
                                                                                <th style="width: 40%;">Question</th>
                                                                                <th style="width: 20%;">Response</th>
                                                                                <th>Remarks</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach ($checklist['questions'] as $index => $question)
                                                                                @php
                                                                                    $response = $checklist1->{'tablet_compress_response_' . ($index + 1)};
                                                                                    $remark = $checklist1->{'tablet_compress_remark_' . ($index + 1)};
                                                                                @endphp
                                            
                                                                                <!-- Check if either response or remark is not empty -->
                                                                                @if ($response || $remark)
                                                                                    <tr>
                                                                                        <td class="flex text-center">
                                                                                            {{ $checklist['prefix'] . '.' . ($index + 1) }}</td>
                                                                                        <td>{{ $question }}</td>
                                                                                        <td>
                                                                                            <div
                                                                                                style="display: flex; justify-content: center; align-items: center; margin: 5%; gap: 5px;">
                                                                                                {{ $response }}
                                                                                            </div>
                                                                                        </td>
                                                                                        <td style="vertical-align: middle;">
                                                                                            <div style="margin: auto; display: flex; justify-content: center;">
                                                                                                {{ $remark }}
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr>
                                                                                @endif
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                @endforeach
                                                            </div>
                                                            <!-- </div> -->
                                                        </div>
                                                    </div>
                                            
                                                @endif
                                            
                                                @php
                                                    $liquidOintmentPackingQuestions = [
                                                        'Is status labels displayed on all equipments?',
                                                        'Equipment cleanliness, check few equipments.',
                                                        'Are machine surfaces that contact materials or finished goods, non–reactive, non-absorptive and non – additive so as not to affect the product?',
                                                        'Are there data to show that cleaning procedures for non-dedicated equipment are adequate to remove the previous materials? Are these procedures been validated?',
                                                        'Do you have written procedures for the safe and correct use of cleaning and sanitizing agents? What are the sanitizing agents used in this plant?',
                                                        'Are there data to show that the residues left by the cleaning and/or sanitizing agent are within acceptable limits when cleaning is performed in accordance with the approved method?',
                                                        'Do you have written procedures that describe the sufficient details of the cleaning schedule, methods, equipment and material? Check for procedure compliance',
                                                        'Are there written instructions describing how to use in-process data to control the process?',
                                                        'Are all pieces of equipment clearly identified with easily visible markings? Check the equipment nos. corresponds to an entry in a log book.',
                                                        'Is equipment inspected immediately prior to use?',
                                                        'Do cleaning instructions include disassembly and drainage procedure, if required to ensure that no cleaning solutions or rinse remains in the equipment?',
                                                        'Has a written schedule been established and is it followed for cleaning of equipment?',
                                                        'Are seams on product-contact surfaces smooth and properly maintained to minimize accumulation of product, dirt, and organic matter and to avoid growth of microorganisms?',
                                                        "Is clean equipment clearly identified as 'cleaned' with a cleaning date shown on the equipment tag? Check for few equipments",
                                                        'Is equipment cleaned promptly after use?',
                                                        'Is there proper storage of cleaned equipment so as to prevent contamination?',
                                                        'Is there adequate system to assure that unclean equipment and utensils are not used (e.g., labeling with clean status)?',
                                                        'Is sewage, trash and other reuse disposed off in a safe and sanitary manner (and with sufficient frequency)?',
                                                        'Are written records maintained on equipment cleaning, sanitizing and maintenance on or near each piece of equipment? Check 2 equipment records.',
                                                        'Are all weighing and measuring performed by one qualified person and checked by a second person? Check the weighing balance record.',
                                                        'All the person working in manufacturing area having proper gowning?',
                                                        'Is there a written procedure specifying the frequency of inspection and replacement for air filters?',
                                                        'Are written operating procedures available for each piece of equipment used in the manufacturing, processing? Check for SOP compliance. Check the list of equipment and equipment details.',
                                                        'Does each piece of equipment have written instructions for maintenance that includes a schedule for maintenance?',
                                                        'Does the process control address all issues to ensure identity, strength, quality and purity of product?',
                                                        'Check the calibration labels for instrument calibration status.',
                                                        'Temperature & RH record log book is available for each staging area.',
                                                        'Material/Product in out register is available for each staging area.',
                                                        'Check for area activity record.',
                                                        'Check for equipment usage record.',
                                                        'Check for general equipment details and accessory details.',
                                                        'Check for man & material movement in the area.',
                                                        'Air handling system qualification, cleaning details and PAO test reports.',
                                                        'Check for purified water hose pipe status and water hold up.',
                                                        'Check for the status labeling in the area and, material randomly.',
                                                        'Check the in-process equipments cleaning status & records.',
                                                        'Are any unplanned process changes (process excursions) documented in the batch record?',
                                                        'Are materials and equipment clearly labeled as to identity and, if appropriate, stage of manufacture?',
                                                        'Is there a preventive maintenance program for all equipment and status of it?',
                                                        'Do you have any sop for operation of autocoator?',
                                                        'Have u any usage log book for autocoator.',
                                                    ];
                                            
                                                    $documentationQuestions = [
                                                        'Do records have doer & checker signatures? Check the timings, date and yield etc in the batch production record.',
                                                        'Is each batch assigned a distinctive code, so that material can be traced through manufacturing and distribution? Check for In process analytical reports.',
                                                        'Is the batch record is on line up to the current stage of a process?',
                                                        'In process carried out as per the written instruction describe in batch record?',
                                                        'Is there any area cleaning record available for all individual areas?',
                                                        'Current version of SOP’s is available in respective areas?',
                                                    ];
                                                @endphp
                                                @if (!empty($data->checklist2))
                                                    <div class="inner-block">
                                                        <div class="content-table">
                                                            <!-- <div class="border-table"> -->
                                                            <div class="block-head">
                                                                Checklist -Tablet Coating
                                                            </div>
                                                            <div>
                                                                @php
                                                                    $checklists = [
                                                                        [
                                                                            'title' => 'STAGE 1 :  COATING',
                                                                            'questions' => $questions,
                                                                            'prefix' => 1,
                                                                        ],
                                                                        [
                                                                            'title' => 'STAGE 2: DOCUMENTATION',
                                                                            'questions' => $questions_documentation,
                                                                            'prefix' => 2,
                                                                        ],
                                                                    ];
                                                                @endphp
                                            
                                                                @foreach ($checklists as $checklist)
                                                                    <div class="block"
                                                                        style="color: #4274da; display: inline-block; border-bottom: 1px solid #4274da;">
                                                                        {{ $checklist['title'] }}
                                                                    </div>
                                                                    <table class="table table-bordered">
                                                                        <thead>
                                                                            <tr>
                                                                                <th style="width: 5%;">Sr. No.</th>
                                                                                <th style="width: 40%;">Question</th>
                                                                                <th style="width: 20%;">Response</th>
                                                                                <th>Remarks</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach ($checklist['questions'] as $index => $question)
                                                                                @php
                                                                                    $response = $checklist2->{'tablet_coating_response_' . ($index + 1)};
                                                                                    $remark = $checklist2->{'tablet_coating_remark_' . ($index + 1)};
                                                                                @endphp
                                            
                                                                                <!-- Check if either response or remark is not empty -->
                                                                                @if ($response || $remark)
                                                                                    <tr>
                                                                                        <td class="flex text-center">
                                                                                            {{ $checklist['prefix'] . '.' . ($index + 1) }}</td>
                                                                                        <td>{{ $question }}</td>
                                                                                        <td>
                                                                                            <div
                                                                                                style="display: flex; justify-content: center; align-items: center; margin: 5%; gap: 5px;">
                                                                                                {{ $response }}
                                                                                            </div>
                                                                                        </td>
                                                                                        <td style="vertical-align: middle;">
                                                                                            <div style="margin: auto; display: flex; justify-content: center;">
                                                                                                {{ $remark }}
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr>
                                                                                @endif
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                @endforeach
                                                            </div>
                                                            <!-- </div> -->
                                                        </div>
                                                    </div>
                                                @endif
                                            
                                            
                                            
                                                @php
                                                    $CapsulePackingQuestions = [
                                                        'equipment status labels displayed on all equipments?',
                                                        'Equipment cleanliness, check few equipments.',
                                                        'Are machine surfaces that contact materials or finished goods, non–reactive, non-absorptive and non-additive so as not to affect the product?',
                                                        'Are there data to show that cleaning procedures for non-dedicated equipment are adequate to remove the previous materials? For active ingredients, have these procedures been validated?',
                                                        'Do you have written procedures for the safe and correct use of cleaning and sanitizing agents? What are the sanitizing agents used in this plant?',
                                                        'Are there data to show that the residues left by the cleaning and/or sanitizing agent are within acceptable limits when cleaning is performed in accordance with the approved method?',
                                                        'Do you have written procedures that describe the sufficient details of the cleaning schedule, methods, equipment, and material? Check for procedure compliance.',
                                                        'Are there written instructions describing how to use in-process data to control the process?',
                                                        'Are all pieces of equipment clearly identified with easily visible markings? Check the equipment numbers correspond to an entry in a log book.',
                                                        'Is equipment inspected immediately prior to use?',
                                                        'Do cleaning instructions include disassembly and drainage procedures, if required, to ensure that no cleaning solutions or rinse remains in the equipment?',
                                                        'Has a written schedule been established and is it followed for cleaning of equipment?',
                                                        'Are seams on product-contact surfaces smooth and properly maintained to minimize accumulation of product, dirt, and organic matter and to avoid the growth of microorganisms?',
                                                        'Is clean equipment clearly identified as “cleaned” with a cleaning date shown on the equipment tag? Check for a few equipments.',
                                                        'Is equipment cleaned promptly after use?',
                                                        'Is there proper storage of cleaned equipment so as to prevent contamination?',
                                                        'Is there an adequate system to assure that unclean equipment and utensils are not used (e.g., labeling with clean status)?',
                                                        'Is sewage, trash, and other refuse disposed of in a safe and sanitary manner (and with sufficient frequency)?',
                                                        'Are written records maintained on equipment cleaning, sanitizing, and maintenance on or near each piece of equipment? Check 2 equipment records.',
                                                        'Are all weighing and measuring performed by one qualified person and checked by a second person? Check the weighing balance record.',
                                                        'Is the pressure differential of every particular area within limit?',
                                                        'Are all persons working in the manufacturing area having proper gowning?',
                                                        'Do you have any SOP regarding the hold time of material during staging?',
                                                        'Is there a written procedure specifying the frequency of inspection and replacement for air filters?',
                                                        'Are written operating procedures available for each piece of equipment used in manufacturing, processing? Check for SOP compliance. Check the list of equipment and equipment details.',
                                                        'Does each piece of equipment have written instructions for maintenance that includes a schedule for maintenance?',
                                                        'Does the process control address all issues to ensure identity, strength, quality, and purity of the product?',
                                                        'Check the calibration labels for instrument calibration status.',
                                                        'Temperature & RH record log book is available for each staging area.',
                                                        'Check for area activity record.',
                                                        'Check for equipment usage record.',
                                                        'Check for general equipment details and accessory details.',
                                                        'Check for man & material movement in the area.',
                                                        'Air handling system qualification, cleaning details and PAO test reports.',
                                                        'Check for purified water hose pipe status and water hold up.',
                                                        'Check for the status labeling in the area and material randomly.',
                                                        'Check the in-process equipment cleaning status & records.',
                                                        'Are any unplanned process changes (process excursions) documented in the batch record?',
                                                        'Are materials and equipment clearly labeled as to identity and, if appropriate, stage of manufacture?',
                                                        'Is there a preventive maintenance program for all equipment and the status of it?',
                                                        'Is there a written procedure for clearing the packaging area after one packaging operation and cleaning before the next operation, especially if the area is used for packaging different materials?',
                                                        'Do you have any standard procedure for the removal of scrap?',
                                                        'Is this plant free from infestation by rodents, birds, insects, and vermin?',
                                                        'Do you have written procedures for the safe use of suitable rodenticides, insecticides, fungicides, and fumigating agents? Check the corresponding records.',
                                                        'Do records have doer & checker signatures? Check the timings, date, and yield, etc. in the batch production record.',
                                                        'Is each batch assigned a distinctive code, so that material can be traced through manufacturing and distribution? Check for In-process analytical reports.',
                                                        'Is the batch record online up to the current stage of the process?',
                                                        'Is the process carried out as per the written instructions described in the batch record?',
                                                        'Is there any area cleaning record available for all individual areas?',
                                                        'Current version  of SOPs available in respective areas?',
                                                    ];
                                                    // $documentationQuestions =[
                                                    //     'Do records have doer & checker signatures? Check the timings, date, and yield, etc. in the batch production record.',
                                                    //     'Is each batch assigned a distinctive code, so that material can be traced through manufacturing and distribution? Check for In-process analytical reports.',
                                                    //     'Is the batch record online up to the current stage of the process?',
                                                    //     'Is the process carried out as per the written instructions described in the batch record?',
                                                    //     'Is there any area cleaning record available for all individual areas?',
                                                    //     'Current version  of SOPs available in respective areas?'];
                                                @endphp
                                                @if (!empty($data->checklist4))
                                                    <div class="inner-block">
                                                        <div class="content-table">
                                                            <!-- <div class="border-table"> -->
                                                            <div class="block-head">
                                                                Checklist - Production (Capsule)
                                                            </div>
                                                            <div>
                                                                @php
                                                                    $checklists = [
                                                                        [
                                                                            'title' => 'STAGE 1: CAPSULE',
                                                                            'questions' => $CapsulePackingQuestions,
                                                                            'prefix' => 1,
                                                                        ],
                                                                        // [
                                                                        //     'title' => 'STAGE 2: DOCUMENTATION',
                                                                        //     'questions' => $documentationQuestions,
                                                                        //     'prefix' => 2
                                                                        // ],
                                                                    ];
                                                                @endphp
                                            
                                                                @foreach ($checklists as $checklist)
                                                                    <div class="block"
                                                                        style="color: #4274da; display: inline-block; border-bottom: 1px solid #4274da;">
                                                                        {{ $checklist['title'] }}
                                                                    </div>
                                                                    <table class="table table-bordered">
                                                                        <thead>
                                                                            <tr>
                                                                                <th style="width: 5%;">Sr. No.</th>
                                                                                <th style="width: 40%;">Question</th>
                                                                                <th style="width: 20%;">Response</th>
                                                                                <th>Remarks</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach ($checklist['questions'] as $index => $question)
                                                                                @php
                                                                                    $response = $checklist4->{'capsule_response_' . ($index + 1)};
                                                                                    $remark = $checklist4->{'capsule_remark_' . ($index + 1)};
                                                                                @endphp
                                            
                                                                                <!-- Check if either response or remark is not empty -->
                                                                                @if ($response || $remark)
                                                                                    <tr>
                                                                                        <td class="flex text-center">
                                                                                            {{ $checklist['prefix'] . '.' . ($index + 1) }}</td>
                                                                                        <td>{{ $question }}</td>
                                                                                        <td>
                                                                                            <div
                                                                                                style="display: flex; justify-content: center; align-items: center; margin: 5%; gap: 5px;">
                                                                                                {{ $response }}
                                                                                            </div>
                                                                                        </td>
                                                                                        <td style="vertical-align: middle;">
                                                                                            <div style="margin: auto; display: flex; justify-content: center;">
                                                                                                {{ $remark }}
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr>
                                                                                @endif
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                @endforeach
                                                            </div>
                                                            <!-- </div> -->
                                                        </div>
                                                    </div>
                                                @endif
                                                @php
                                                    $liquidOintmentPacking = [
                                                        'Is status labels displayed on all equipments?',
                                                        'Equipment cleanliness, check few equipments.',
                                                        'Are machine surfaces that contact materials or finished goods, non–reactive, non-absorptive and non – additive so as not to affect the product?',
                                                        'Are there data to show that cleaning procedures for non-dedicated equipment are adequate to remove the previous materials? Are these procedures been validated?',
                                                        'Do you have written procedures for the safe and correct use of cleaning and sanitizing agents? What are the sanitizing agents used in this plant?',
                                            
                                                        'Are there data to show that the residues left by the cleaning and/or sanitizing agent are within acceptable limits when cleaning is performed in accordance with the approved method?',
                                                        'Do you have written procedures that describe the sufficient details of the cleaning schedule, methods, equipment and material? Check for procedure compliance',
                                                        'Are there written instructions describing how to use in-process data to control the process?',
                                                        'Are all pieces of equipment clearly identified with easily visible markings? Check the equipment nos. corresponds to an entry in a log book.',
                                                        'Is equipment inspected immediately prior to use?',
                                            
                                                        'Do cleaning instructions include disassembly and drainage procedure, if required to ensure that no cleaning solutions or rinse remains in the equipment?',
                                                        'Has a written schedule been established and is it followed for cleaning of equipment?',
                                                        'Are seams on product-contact surfaces smooth and properly maintained to minimize accumulation of product, dirt, and organic matter and to avoid growth of microorganisms?',
                                                        "Is clean equipment clearly identified as 'cleaned' with a cleaning date shown on the equipment tag? Check for few equipments",
                                                        'Is equipment cleaned promptly after use?',
                                            
                                                        'Is there proper storage of cleaned equipment so as to prevent contamination?',
                                                        'Is there adequate system to assure that unclean equipment and utensils are not used (e.g., labeling with clean status)?',
                                                        'Is sewage, trash and other reuse disposed off in a safe and sanitary manner (and with sufficient frequency)?',
                                                        'Are written records maintained on equipment cleaning, sanitizing and maintenance on or near each piece of equipment? Check 2 equipment records.',
                                            
                                                        'Are all weighing and measuring performed by one qualified person and checked by a second person? Check the weighing balance record.',
                                                        'All the person working in packing area having proper gowning?',
                                                        'Are written operating procedures available for each piece of equipment used in the manufacturing, processing? Check for SOP compliance. Check the list of equipment and equipment details.',
                                                        'Does each equipment have written instructions for maintenance that includes a schedule for maintenance?',
                                                        'Does the process control address all issues to ensure identity, strength, quality and purity of product?',
                                                        'Check the calibration labels for instrument calibration status.',
                                                        'Temperature & RH record log book is available for each staging area.',
                                                        'Check for area activity record.',
                                                        'Check for equipment usage record.',
                                                        'Check for general equipment details and accessory details.',
                                                        'Check for man & material movement in the area.',
                                                        'Air handling system qualification, cleaning details and PAO test reports.',
                                                        'Check for the status labeling in the area and, material randomly.',
                                                        'Check the in-process equipments cleaning status & records.',
                                                        'Are any unplanned process changes (process excursions) documented in the batch record?',
                                                        'Status label of area & equipment available?',
                                                        'Have you any proper storage area for primary and secondary packing material?',
                                                        'Do you have proper segregation system for keeping product/batch separately?',
                                                        'Stereo impression record available? Check the record for any 2 batches.',
                                                        'Where you keep the rejected tube / bottle/ cartons?',
                                                        'Is there any standard practice for destruction of printed bottle label & printed cartons?',
                                                        'Is there a written procedure for clearing the packaging area after one packaging operation, and cleaning before the next operation, especially if the area is used for packaging different materials?',
                                                        'Have you any standard procedure for removal of scrap?',
                                                        'Is there any procedure to cross verify the dispensed packaging material before starting the packaging.',
                                                        'Is there Lux Level of all working table is within acceptance limit?',
                                                    ];
                                            
                                                    $liquidOintmentQuestions = [
                                                        'Do records have doer & checker signatures? Check the timings, date and yield etc in the batch production record.',
                                                        'Is each batch assigned a distinctive code, so that material can be traced through manufacturing and distribution? Check for In process analytical reports.',
                                                        'Is the batch record is on line up to the current stage of a process?',
                                                        'In process carried out as per the written instruction describe in batch record?',
                                                        'Is there any area cleaning record available for all individual areas?',
                                                        'Current version of SOP’s is available in respective areas?',
                                                    ];
                                                @endphp
                                                @if (!empty($data->checklist5))
                                                    <div class="inner-block">
                                                        <div class="content-table">
                                                            <!-- <div class="border-table"> -->
                                                            <div class="block-head">
                                                                Checklist - Liquid/Ointment Packing </div>
                                                            <div>
                                                                @php
                                                                    $checklists = [
                                                                        [
                                                                            'title' => 'STAGE 1 : LIQUIDE/OINTMENT PACKING',
                                                                            'questions' => $liquidOintmentPacking,
                                                                            'prefix' => 1,
                                                                        ],
                                                                        [
                                                                            'title' => 'STAGE 2: DOCUMENTATION',
                                                                            'questions' => $liquidOintmentQuestions,
                                                                            'prefix' => 2,
                                                                        ],
                                                                    ];
                                                                @endphp
                                            
                                                                @foreach ($checklists as $checklist)
                                                                    <div class="block"
                                                                        style="color: #4274da; display: inline-block; border-bottom: 1px solid #4274da;">
                                                                        {{ $checklist['title'] }}
                                                                    </div>
                                                                    <table class="table table-bordered">
                                                                        <thead>
                                                                            <tr>
                                                                                <th style="width: 5%;">Sr. No.</th>
                                                                                <th style="width: 40%;">Question</th>
                                                                                <th style="width: 20%;">Response</th>checklist6
                                                                                <th>Remarks</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach ($checklist['questions'] as $index => $question)
                                                                                @php
                                                                                    $response = $checklist5->{'liquid_ointments_response_' . ($index + 1)};
                                                                                    $remark = $checklist5->{'liquid_ointments_remark_' . ($index + 1)};
                                                                                @endphp
                                            
                                                                                <!-- Check if either response or remark is not empty -->
                                                                                @if ($response || $remark)
                                                                                    <tr>
                                                                                        <td class="flex text-center">
                                                                                            {{ $checklist['prefix'] . '.' . ($index + 1) }}</td>
                                                                                        <td>{{ $question }}</td>
                                                                                        <td>
                                                                                            <div
                                                                                                style="display: flex; justify-content: center; align-items: center; margin: 5%; gap: 5px;">
                                                                                                {{ $response }}
                                                                                            </div>
                                                                                        </td>
                                                                                        <td style="vertical-align: middle;">
                                                                                            <div style="margin: auto; display: flex; justify-content: center;">
                                                                                                {{ $remark }}
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr>
                                                                                @endif
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                @endforeach
                                                            </div>
                                                            <!-- </div> -->
                                                        </div>
                                                    </div>
                                                @endif
                                            
                                                @php
                                                    $dispensingAndManufacturingQuestions = [
                                                        'Is access to the facility restricted?',
                                                        'Is the dispensing area cleaned as per SOP?',
                                                        'Check the status label of area and equipment.',
                                                        'Are all raw materials carry proper label?',
                                                        'Standard operating procedure for dispensing of raw material is displayed?',
                                                        'All the person involved in dispensing having proper gowning?',
                                                        'Where you keep the materials after dispensing?',
                                                        'Is there any log book for keeping the record of dispensing?',
                                                        'Have you any standard practice to cross check the approved status of raw materials before dispensing?',
                                                        'Are all balances calibrated which are to be used for dispensing?',
                                                        'Is the pressure differential of RLAF is within acceptance limit? What is the limit? _______',
                                                        'Is the pressure differential of the area is within acceptance limit? Check the pressure differential__________',
                                                        'Is there any record for room temperature & relative humidity? Check the temperature _____°C & RH _____%',
                                                        'Is status labels displayed on all equipments?',
                                                        'Equipment cleanliness, check few equipments.',
                                                        'Are machine surfaces that contact materials or finished goods, non-reactive, non-absorptive and non-additive so as not to affect the product?',
                                                        'Are there data to show that cleaning procedures for non-dedicated equipment are adequate to remove the previous materials? For active ingredients, have these procedures been validated?',
                                                        'Do you have written procedures for the safe and correct use of cleaning and sanitizing agents? What are the sanitizing agents used in this plant?',
                                                        'Are there data to show that the residues left by the cleaning and/or sanitizing agent are within acceptable limits when cleaning is performed in accordance with the approved method?',
                                                        'Do you have written procedures that describe the sufficient details of the cleaning schedule, methods, equipment and material? Check for procedure compliance.',
                                                        'Are there written instructions describing how to use in-process data to control the process?',
                                                        'Are all pieces of equipment clearly identified with easily visible markings? Check the equipment nos. corresponds to an entry in a log book.',
                                                        'Is equipment inspected immediately prior to use?',
                                                        'Do cleaning instructions include disassembly and drainage procedure, if required to ensure that no cleaning solutions or rinse remains in the equipment?',
                                                        'Has a written schedule been established and is it followed for cleaning of equipment?',
                                                        'Are seams on product-contact surfaces smooth and properly maintained to minimize accumulation of product, dirt, and organic matter and to avoid growth of microorganisms?',
                                                        'Is clean equipment clearly identified as “cleaned” with a cleaning date shown on the equipment tag? Check for few equipments.',
                                                        'Is equipment cleaned promptly after use?',
                                                        'Is there proper storage of cleaned equipment so as to prevent contamination?',
                                                        'Is there adequate system to assure that unclean equipment and utensils are not used (e.g., labeling with clean status)?',
                                                        'Is sewage, trash and other reuse disposed off in a safe and sanitary manner (and with sufficient frequency)?',
                                                        'Are written records maintained on equipment cleaning, sanitizing and maintenance on or near each piece of equipment? Check 2 equipment records.',
                                                        'Are all weighing and measuring performed by one qualified person and checked by a second person? Check the weighing balance record.',
                                                        'All the person working in manufacturing area having proper gowning?',
                                                        'Is there any procedure for cleaning of PLM?',
                                                        'Is there any procedure for cleaning of wax melting vessel?',
                                                        'Is the pressure differential of every particular area are within limit?',
                                                        'Is there any procedure for cleaning of transfer pump?',
                                                        'Is there any procedure for cleaning of liquid Mfg tank?',
                                                        'Is there any procedure for cleaning of transfer line?',
                                                        'Check the calibration status of temperature indicator of wax melting vessel.',
                                                        'Have you any SOP regarding Hold time of material during staging?',
                                                        'Is there a written procedure specifying the frequency of inspection and replacement for air filters?',
                                                        'Are written operating procedures available for each piece of equipment used in the manufacturing, processing? Check for SOP compliance. Check the list of equipment and equipment details.',
                                                        'Does each piece of equipment have written instructions for maintenance that includes a schedule for maintenance?',
                                                        'Does the process control address all issues to ensure identity, strength, quality and purity of product?',
                                                        'Check the calibration labels for instrument calibration status.',
                                                        'Temperature & RH record log book is available for each staging area.',
                                                        'Is there any procedure for operation of tube filling and sealing machine?',
                                                        'Is there any procedure for bottle washing, filling, and sealing machine?',
                                                        'Check for area activity record.',
                                                        'Check for equipment usage record.',
                                                        'Check for general equipment details and accessory details.',
                                                        'Check for man & material movement in the area.',
                                                        'Air handling system qualification, cleaning details and PAO test reports.',
                                                        'Check purified water hose pipe status and water hold up.',
                                                        'Check for the status labeling in the area and material randomly.',
                                                        "Check the in-process equipment's cleaning status & records.",
                                                        'Are any unplanned process changes (process excursions) documented in the batch record?',
                                                        'Do records have doer & checker signatures? Check the timings, date and yield etc in the batch production record.',
                                                        'Is each batch assigned a distinctive code, so that material can be traced through manufacturing and distribution? Check for In process analytical reports.',
                                                        'Is the batch record on line up to the current stage of a process?',
                                                        'In process carried out as per the written instruction describe in batch record?',
                                                        'Is there any area cleaning record available for all individual areas?',
                                                        "Current version of SOP's is available in respective areas?",
                                                    ];
                                            
                                                @endphp
                                                @if (!empty($data->checklist6))
                                                    <div class="inner-block">
                                                        <div class="content-table">
                                                            <!-- <div class="border-table"> -->
                                                            <div class="block-head">
                                                                Checklist - Production(Liquid/Ointment Dispensing & Manufacturing) </div>
                                                            <div>
                                                                @php
                                                                    $checklists = [
                                                                        [
                                                                            'title' => 'STAGE 1: DISPENSING',
                                                                            'questions' => $dispensingAndManufacturingQuestions,
                                                                            'prefix' => 1,
                                                                        ],
                                                                    ];
                                                                @endphp
                                            
                                                                @foreach ($checklists as $checklist)
                                                                    <div class="block"
                                                                        style="color: #4274da; display: inline-block; border-bottom: 1px solid #4274da;">
                                                                        {{ $checklist['title'] }}
                                                                    </div>
                                                                    <table class="table table-bordered">
                                                                        <thead>
                                                                            <tr>
                                                                                <th style="width: 5%;">Sr. No.</th>
                                                                                <th style="width: 40%;">Question</th>
                                                                                <th style="width: 20%;">Response</th>
                                                                                <th>Remarks</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach ($checklist['questions'] as $index => $question)
                                                                                @php
                                                                                    $response = $checklist6->{'dispensing_and_manufacturing_' . ($index + 1)};
                                                                                    $remark = $checklist6->{'dispensing_and_manufacturing_remark_' . ($index + 1)};
                                                                                @endphp
                                            
                                                                                <!-- Check if either response or remark is not empty -->
                                                                                @if ($response || $remark)
                                                                                    <tr>
                                                                                        <td class="flex text-center">
                                                                                            {{ $checklist['prefix'] . '.' . ($index + 1) }}</td>
                                                                                        <td>{{ $question }}</td>
                                                                                        <td>
                                                                                            <div
                                                                                                style="display: flex; justify-content: center; align-items: center; margin: 5%; gap: 5px;">
                                                                                                {{ $response }}
                                                                                            </div>
                                                                                        </td>
                                                                                        <td style="vertical-align: middle;">
                                                                                            <div style="margin: auto; display: flex; justify-content: center;">
                                                                                                {{ $remark }}
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr>
                                                                                @endif
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                @endforeach
                                                            </div>
                                                            <!-- </div> -->
                                                        </div>
                                                    </div>
                                                @endif
                                            
                                                @php
                                                    $qualityAssuranceQuestions = [
                                                        'Does the QA unit have a person specifically charged with the responsibility of designing, revising and obtaining approval for production and testing procedures, forms and records?',
                                                        'Is the production batch record and release test results reviewed for accuracy and completeness before a batch of finished product is released?',
                                                        'Does a formal auditing function exist in the QA department?',
                                                        'Does a written SOP specify who shall conduct audit and qualifications (education, training and experience) for those who conduct audits?',
                                                        'Does a written SOP specify the scope and frequency of audits and how such audits are to be documented?',
                                                        'Are vendors periodically inspected according to a written procedure?',
                                                        'Is the procedure for confirming vendor test results written and followed?',
                                                        'Does a written procedure or SOP to identify the steps required for product recall? Check the record.',
                                                        'Are complaints, whether received in oral or written form, documented in writing retained in a designated file? (Customer complaint register and its related documents)',
                                                        'Are complaints reviewed on a timely basis by the quality assurance unit?',
                                                        'Is the action taken in response to each complaint documented?',
                                                        'Are complaint investigations documented and do they include investigation steps, findings and follow up steps, if required? Are dates included for each entry?',
                                                        'Check for Document control system',
                                                        'Check for annual product quality review. (SOP)',
                                                        'Check for trend on finished product quality attributes',
                                                        'Check for validation documents – Cleaning and process validation',
                                                        'Check for batch release system',
                                                        'Check for Change control proposal system',
                                                        'Check for vendor samples evaluation',
                                                        'Check for Batch Production Record review system and record',
                                                        'Do you have written procedures for approval / rejections of raw materials, intermediates, finished products, packing and packaging materials?',
                                                        'Is each batch assigned a distinctive code, so material can be traced through analysis?',
                                                        'Does inspection start with visual examination for appropriate labeling, signs of damage or contamination?',
                                                        'Is the sampling technique written and followed for each type of material?',
                                                        'Is the quantity of samples collected sufficient for analysis and reserve in case re testing or verification is required?',
                                                        'Is containers are cleaned before taken samples',
                                                        'Are stratified samples composited for analysis?',
                                                        'Containers from which samples have been taken are so marked indicating date and approximate amount taken',
                                                        'Are quality assurance review and approval required for reprocessing of materials, if any? (SOP)',
                                                        'Has the each product been tested for stability on a written protocol?',
                                                        'Does quality control & Quality Assurance review such reprocessed returned goods and test such materials for conformance to specifications before releasing such material for release?',
                                                        'Check for the compliance of standard operating procedure',
                                                        'Check for department organization chart and job responsibility',
                                                        'Do you have written procedure for calibration of IPQC instruments? Check for its record and corresponding labels',
                                                        'Is OOS investigation carried out for analytical failures? Check for compliance of OOS system against the system',
                                                        'Check the 4-5 deviations record randomly? Are they confirming to SOP. ?',
                                                        'Check whether the equipments qualification / requalification completed as per schedule',
                                                        'Responsibilities and Authority - Are the QA/QC organization’s authority and responsibilities clearly defined in writing?',
                                                        'Does QA assure that manufacturing and testing records are reviewed before batches are released for sale?',
                                                        'Is there an adequate program for handling complaints, including investigation to determine the causes, corrective actions, verification of the effectiveness of corrective actions, a target time frame for responding; trend analysis, and notification of appropriate parties including management?',
                                                        'Is a log maintained for changes to documents and facility?',
                                                    ];
                                            
                                                @endphp
                                                @if (!empty($data->checklist7))
                                                    <div class="inner-block">
                                                        <div class="content-table">
                                                            <!-- <div class="border-table"> -->
                                                            <div class="block-head">
                                                                Checklist - Quality Assurance
                                                            </div>
                                                            <div>
                                                                @php
                                                                    $checklists = [
                                                                        [
                                                                            'title' => 'Checklist for Quality Assurance',
                                                                            'questions' => $qualityAssuranceQuestions,
                                                                            'prefix' => 1,
                                                                        ],
                                                                        // [
                                                                        //     'title' => 'STAGE 2: DOCUMENTATION',
                                                                        //     'questions' => $documentationQuestions,
                                                                        //     'prefix' => 2
                                                                        // ],
                                                                    ];
                                                                @endphp
                                            
                                                                @foreach ($checklists as $checklist)
                                                                    <div class="block"
                                                                        style="color: #4274da; display: inline-block; border-bottom: 1px solid #4274da;">
                                                                        {{ $checklist['title'] }}
                                                                    </div>
                                                                    <table class="table table-bordered">
                                                                        <thead>
                                                                            <tr>
                                                                                <th style="width: 5%;">Sr. No.</th>
                                                                                <th style="width: 40%;">Question</th>
                                                                                <th style="width: 20%;">Response</th>
                                                                                <th>Remarks</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach ($checklist['questions'] as $index => $question)
                                                                                @php
                                                                                    $response = $checklist7->{'ointment_packing_' . ($index + 1)};
                                                                                    $remark = $checklist7->{'ointment_packing_remark_' . ($index + 1)};
                                                                                @endphp
                                            
                                                                                <!-- Check if either response or remark is not empty -->
                                                                                @if ($response || $remark)
                                                                                    <tr>
                                                                                        <td class="flex text-center">
                                                                                            {{ $checklist['prefix'] . '.' . ($index + 1) }}</td>
                                                                                        <td>{{ $question }}</td>
                                                                                        <td>
                                                                                            <div
                                                                                                style="display: flex; justify-content: center; align-items: center; margin: 5%; gap: 5px;">
                                                                                                {{ $response }}
                                                                                            </div>
                                                                                        </td>
                                                                                        <td style="vertical-align: middle;">
                                                                                            <div style="margin: auto; display: flex; justify-content: center;">
                                                                                                {{ $remark }}
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr>
                                                                                @endif
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                @endforeach
                                                            </div>
                                                            <!-- </div> -->
                                                        </div>
                                                    </div>
                                                @endif
                                            
                                            
                                                {{-- Engineering --}}
                                                @php
                                                    $checklistEngineering = [
                                                        'Is there a master list of all equipment that specifies those requiring maintenance and/or calibration?',
                                                        'Are written procedures available for set-up of equipment?',
                                                        'Are written procedures available for maintenance of equipment?',
                                                        'Are written procedures available for cleaning of equipment?',
                                                        'Are written procedures available for calibration of manufacturing equipment?',
                                                        'Are written procedures available for calibration of control instruments?',
                                                        'Are records kept for the sequence of products manufactured on particular equipment?',
                                                        'Are records kept for maintenance and cleaning logs?',
                                                        'Are records kept for calibration of manufacturing equipment?',
                                                        'Are records kept for calibration of control instruments?',
                                                        'Is equipment designed to prevent adulteration of product with lubricants, coolants, fuel, metal fragments, or other extraneous materials?',
                                                        'Are holding, conveying and manufacturing systems designed and constructed so as to allow them to be maintained in a sanitary condition?',
                                                        'Are there SOPs for inspection (monitoring the condition) and maintenance of equipment and of measuring and testing instruments?',
                                                        'Do SOPs assign responsibilities; include schedules; describe methods, equipment, and materials to be used; and require maintenance of records?',
                                                        'If water is purified for use in the process, is the purification system periodically sanitized and appropriately maintained?',
                                                        'Does a SOP specify that equipment cannot be used if it is beyond the calibration due date, and describe actions to be taken if equipment is used that is found to have been beyond the due date or is found to be out of calibration time?',
                                                        'Are there SOPs for calibration of critical equipment, and measuring and testing instruments?',
                                                        'Do SOPs assign responsibilities; include schedules; describe methods; equipment, and materials to be used, including calibration over actual range of use and standards traceable to national standards; and include specifications and tolerances?',
                                                        'Is calibrated equipment labeled with date of calibration and date of next calibration is due?',
                                                        'Is equipment in use observed to be within calibration dating?',
                                                        'Are periodic verifications performed on critical production scales (e.g., for raw material dispensing or portable scales) to assure that they remain within calibration in the time between full calibrations?',
                                                        'Are records maintained for maintenance and calibration operations?',
                                                        'Is there any standard procedure for maintenance and calibration operations?',
                                                        'Check the filter drying room. Is there procedure for the filter drying? Check 2- 3 filter randomly.',
                                                        'Do you maintain the filter cleaning record?',
                                                    ];
                                            
                                                    $checklistBuilding = [
                                                        'Check the all piping properly painted with colour code.',
                                                        'Check all piping to check for air / water / steam leakages if any.',
                                                        'Check the hot and cold lines / surfaces properly insulated.',
                                                        'Check any cracks in wall and updating wall painting.',
                                                        'All doors and its door closer to function properly.',
                                                        'Check all the toilets, bathrooms valves and flush.',
                                                    ];
                                            
                                                    $checklistHVAC = ['Check pressure gradient and cleaning of Area.', 'Check area cleanness and HEPA grills.'];
                                                @endphp
                                            
                                                @if (!empty($data->checklist9))
                                                    <div class="inner-block">
                                                        <div class="content-table">
                                                            <!-- <div class="border-table"> -->
                                                            <div class="block-head">
                                                                Checklist - Engineering
                                                            </div>
                                                            <div>
                                                                @php
                                                                    $checklists = [
                                                                        [
                                                                            'title' => 'Checklist for Engineering',
                                                                            'questions' => $checklistEngineering,
                                                                            'prefix' => 1,
                                                                        ],
                                                                        [
                                                                            'title' => 'Checklist for Building Facility',
                                                                            'questions' => $checklistBuilding,
                                                                            'prefix' => 2,
                                                                        ],
                                                                        [
                                                                            'title' => 'Checklist for HVAC/HEPA',
                                                                            'questions' => $checklistHVAC,
                                                                            'prefix' => 3,
                                                                        ],
                                                                    ];
                                                                @endphp
                                            
                                                                @foreach ($checklists as $checklist)
                                                                    <div class="block"
                                                                        style="color: #4274da; display: inline-block; border-bottom: 1px solid #4274da;">
                                                                        {{ $checklist['title'] }}
                                                                    </div>
                                                                    <table class="table table-bordered">
                                                                        <thead>
                                                                            <tr>
                                                                                <th style="width: 5%;">Sr. No.</th>
                                                                                <th style="width: 40%;">Question</th>
                                                                                <th style="width: 20%;">Response</th>
                                                                                <th>Remarks</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach ($checklist['questions'] as $index => $question)
                                                                                @php
                                                                                    $response = $checklist9->{'engineering_response_' . ($index + 1)};
                                                                                    $remark = $checklist9->{'engineering_remark_' . ($index + 1)};
                                                                                @endphp
                                            
                                                                                <!-- Check if either response or remark is not empty -->
                                                                                @if ($response || $remark)
                                                                                    <tr>
                                                                                        <td class="flex text-center">
                                                                                            {{ $checklist['prefix'] . '.' . ($index + 1) }}</td>
                                                                                        <td>{{ $question }}</td>
                                                                                        <td>
                                                                                            <div
                                                                                                style="display: flex; justify-content: center; align-items: center; margin: 5%; gap: 5px;">
                                                                                                {{ $response }}
                                                                                            </div>
                                                                                        </td>
                                                                                        <td style="vertical-align: middle;">
                                                                                            <div style="margin: auto; display: flex; justify-content: center;">
                                                                                                {{ $remark }}
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr>
                                                                                @endif
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                @endforeach
                                                            </div>
                                                            <!-- </div> -->
                                                        </div>
                                                    </div>
                                                @endif
                                            
                                                @php
                                                    $checklistqualitycontrol = [
                                                        'Are the complete index and a complete set of applicable SOPs available in the department?',
                                                        'Are the index & annexure current?',
                                                        'Are training records of the employees working in the department up-to-date?',
                                                        'Is Job Description of the employees working in the department up-to-date?',
                                                        // "Have the employees undergone training in the following areas?",
                                                        'cGLP (Related: SOP for Good Laboratory Practices)',
                                                        'SOPs',
                                                        'Analytical Techniques',
                                                        'EU_GMP',
                                                        'Is Training Calendar of the employees working in the department up-to-date?',
                                                        'Is an up-to-date organizational chart of the Quality Control Department available?',
                                                        'Are all employees following the garments SOP, including where necessary masks & gloves?',
                                                        'Is the laboratory neat and orderly with sufficient space for equipment and operations?',
                                                        'Is the good housekeeping followed?',
                                                        'Are the laboratory instruments/equipment qualified?',
                                                        // "Are all reagents and solutions",
                                                        'Clearly labeled with their proper name?',
                                                        'Labeled with the date of receipt and/or expiration date?',
                                                        // "Are prepared solutions labeled with the",
                                                        'Name of the person who prepared them?',
                                                        'Date of preparation?',
                                                        'Expiration date?',
                                                        'Is there any written procedure available for status labeling?',
                                                        'Is the area qualified? Have any modification in the facility in the last 6 months?',
                                                        'Are the entire area log books updated?',
                                                        'Is there an approved preventive maintenance program for all equipment/instruments used in the laboratory?',
                                                        'Is there an SOP for corrective action if an instrument is found to be out of calibration?',
                                                        'Where standards are used to calibrate an instrument, is there a written procedure for their preparation?',
                                                        'Is a specific person responsible for the receipt of samples for testing?',
                                                        'Is there a written SOP describing sample receipt and recording (logging in)?',
                                                        'Where are samples stored before and after testing?',
                                                        'Are samples retained after completion of testing and reporting? If not, What happens to samples after testing and reporting are complete?',
                                                        'Is there a time limit on how long a sample may remain in the laboratory prior to testing?',
                                                        'Is the approved vendor list for all raw materials and packing materials available?',
                                                        'Is there any data backup policy available?',
                                                        'Is there any written procedure for the Audit trail?',
                                                        'Is there any written procedure for the management of software & creation of user ID?',
                                                        'Are there approved test procedures available for all tests performed in the laboratory?',
                                                        'Is there a written procedure for ensuring that all pharmacopoeial procedures are updated when a supplemental monograph is issued?',
                                                        'Has the test method been validated for precision and reliability?',
                                                        'Examine the work currently being performed on the HPLCs.',
                                                        'Has the analyst recorded all the relevant details of the product being tested, including the attachment of printouts or record of weighing?',
                                                        'Is there documented evidence that system suitability was determined prior to the use of the chromatography in the analysis?',
                                                        'Is there a reference to the test method used in the analyst’s Test Data Sheet (TDS)?',
                                                        'Are laboratory records indicating the date of receipt of the sample and expiry date?',
                                                        'Are appropriate reference standards used and are they stored in a proper manner to ensure stability? Are their expiration dates adequately monitored so they are not used beyond the expiration dates?',
                                                        'Is reference standard kept under proper storage condition?',
                                                        'Are working standards prepared as per the protocol? Check for its storage condition',
                                                        'Is there a record of the preparation of volumetric solutions?',
                                                        'Are volumetric solutions freshly prepared? If stored, what expiration date is given?',
                                                        'Are raw data reviewed prior to release from the laboratory by a person other than the analyst who performed the test?',
                                                        'Check method validation for any product which is done in between two self-inspections with respect to SOP.',
                                                        'Is a stability study schedule available?',
                                                        'Are protocols for all stability study samples available?',
                                                        'Does the procedure for keeping stability samples available?',
                                                        'Are stability samples kept as per the storage requirement?',
                                                        'Is the stability summary available?',
                                                        'Are records maintained of nonconforming materials, related investigations and corrective actions?',
                                                        'For active ingredients, is there an SOP for investigation of out-of-specification (OOS) test results to assure that a uniform procedure is followed to determine why the OOS result occurred and that corrective actions are implemented?',
                                                        'Raw Material control - Is a list of acceptable suppliers (i.e. approved vendor list) maintained and are incoming raw materials checked against it?',
                                                        'Are statistical sampling plans used to assure that the samples are representative of the lot?',
                                                        'Are sampled containers labeled with sampler’s name and date of sampling?',
                                                        'Are there complete written instructions for testing and approving raw materials, including methods, equipment, operating parameters, acceptance specifications?',
                                                        'Are raw materials approved before being used in production?',
                                                        'Are appropriate controls exercised to assure that they are not used in a batch prior to release by Quality Control?',
                                                        'If raw materials are accepted on certificates of analysis, have suppliers been appropriately certified or qualified, have results on the COA been verified by in-house testing?',
                                                        'Is raw materials identification test performed on every batch and receipt?',
                                                        'Is there an effective system for monitoring and retesting or re-evaluating stored raw materials to assure that they are not used beyond their recommended use date?',
                                                        'In-process testing - Are there complete written instructions for testing and approving in-process materials, including methods, equipment, operating parameters, acceptance specifications?',
                                                        'If operators perform in-process testing, have they been trained and was the training documented? Does QC periodically verify their results?',
                                                        'Final product control - Is every batch sampled according to a plan that assures that the sample is representative of the batch?',
                                                        'When and where is the finished product sampled for release?',
                                                        'Is every product batch tested and approved before shipment?',
                                                        'Are there complete written instructions for testing and releasing final product, including methods, equipment, operating parameters, and acceptance specifications?',
                                                        'If skip lot testing is done, does the COA clearly indicate which tests are performed on every lot and which are critical via skip lot testing?',
                                                        'Have non-compendial methods been validated, including accuracy, linearity, specificity, ruggedness, and comparison with compendial methods, OR have compendial methods been verified to function properly in the company’s laboratory?',
                                                        'Is the stability protocol available?',
                                                        'Are these stability chambers available to carryout stability of the product at',
                                                        'Do you keep both hard copy and electronic copy of temperature/Rh monitoring?',
                                                        'Are the stability results reviewed by a qualified, experienced person?',
                                                        'Is stability study in primary pack done for different products?',
                                                        'Do laboratories have adequate space and are they clean and orderly, with appropriate equipment for required tests?',
                                                        'Are calibrated instruments labeled with date calibrated and date next calibration is due?',
                                                        'Are daily or weekly calibration verifications performed on analytical balances using a range of weights (high, middle, low) based on the operating range of the balance?',
                                                        'Are in-process materials tested at appropriate phases for identity, strength, quality, and purity and are they approved or rejected by Quality control?',
                                                        'Are there laboratory controls including sampling and testing procedures to assure conformance of containers, closures in process materials and finished product specifications?',
                                                        'Are written sampling and testing procedures and acceptance criteria available for each product?',
                                                        'Are specific tests for foreign particles done?',
                                                        'Are Packing materials approved before being used in production?',
                                                        'Check for compliance of stability data and its summary',
                                                        'Check for Analytical Data Sheet',
                                                        'Are reagents and microbiological media adequately controlled and monitored to assure that they are periodically replaced and that old reagents are not used?',
                                                        'Are all containers of materials or solutions adequately labeled to determine identity and dates of preparation and expiration (if applicable)?',
                                                        'Are data recorded in notebooks or on pre-numbered sheets, including appropriate cross-reference to the location of relevant spectra and chromatograms? Are equipment ID numbers recorded for each analysis?',
                                                        'Are data and calculations checked by a second person and countersigned?',
                                                        'Are Material safety data sheet (MSDS) of chemical which are used is available?',
                                                        'Microbiological Laboratories',
                                                        'Are positive and negative controls used for testing? Are their results recorded?',
                                                        'Is growth support testing with low levels of organisms performed on all incoming media lots and is it documented?',
                                                        'Is an expiration date assigned to prepared media and are prepared media stored at manufacturers’ recommended storage temperatures?',
                                                        'Are isolates from microbiological testing identified if appropriate?',
                                                        'Is each lot of microbial ID systems checked with positive and negative controls?',
                                                    ];
                                                @endphp
                                            
                                                @if (!empty($data->checklist10))
                                                    <div class="inner-block">
                                                        <div class="content-table">
                                                            <!-- <div class="border-table"> -->
                                                            <div class="block-head">
                                                                Checklist - Quality Control
                                                            </div>
                                                            <div>
                                                                @php
                                                                    $checklists = [
                                                                        [
                                                                            'title' => 'Checklist for Quality Assurance',
                                                                            'questions' => $checklistqualitycontrol,
                                                                            'prefix' => 1,
                                                                        ],
                                                                    ];
                                                                @endphp
                                            
                                                                @foreach ($checklists as $checklist)
                                                                    <div class="block"
                                                                        style="color: #4274da; display: inline-block; border-bottom: 1px solid #4274da;">
                                                                        {{ $checklist['title'] }}
                                                                    </div>
                                                                    <table class="table table-bordered">
                                                                        <thead>
                                                                            <tr>
                                                                                <th style="width: 5%;">Sr. No.</th>
                                                                                <th style="width: 40%;">Question</th>
                                                                                <th style="width: 20%;">Response</th>
                                                                                <th>Remarks</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach ($checklist['questions'] as $index => $question)
                                                                                @php
                                                                                    $response = $checklist10->{'quality_control_response_' . ($index + 1)};
                                                                                    $remark = $checklist10->{'quality_control_remark__' . ($index + 1)};
                                                                                @endphp
                                            
                                                                                <!-- Check if either response or remark is not empty -->
                                                                                @if ($response || $remark)
                                                                                    <tr>
                                                                                        <td class="flex text-center">
                                                                                            {{ $checklist['prefix'] . '.' . ($index + 1) }}</td>
                                                                                        <td>{{ $question }}</td>
                                                                                        <td>
                                                                                            <div
                                                                                                style="display: flex; justify-content: center; align-items: center; margin: 5%; gap: 5px;">
                                                                                                {{ $response }}
                                                                                            </div>
                                                                                        </td>
                                                                                        <td style="vertical-align: middle;">
                                                                                            <div style="margin: auto; display: flex; justify-content: center;">
                                                                                                {{ $remark }}
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr>
                                                                                @endif
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                @endforeach
                                                            </div>
                                                            <!-- </div> -->
                                                        </div>
                                                    </div>
                                                @endif
                                                @php
                                                    $questions_stores = [
                                                        'Is there a potential for contamination or cross-contamination from any sources? If so, how it is controlled / prevented?',
                                                        'Are there complete written master manufacturing instructions that specify formula, names and codes of raw materials, equipment, manufacturing flow, operating parameters, in-process sampling, packaging materials, labeling, and documentation of each significant step?',
                                                        'Are critical environmental parameters monitored and recorded?',
                                                        'Is there an SOP for receiving, handling, storing and accountability of pre-printed labels?',
                                                        'If filled unlabeled containers are set aside for future labeling, is there sufficient identification to determine name, strength, quantity, lot number and other information needed for traceability?',
                                                        'Is a list of acceptable suppliers maintained and are incoming raw materials checked against it?',
                                                        'Are statistical sampling plans used to assure that the samples are representative of the lot?',
                                                        'Are sampled containers labeled with sampler’s name and date of sampling?',
                                                        'Are there complete written instructions for testing and approving raw materials, including methods, equipment, operating parameters, acceptance specifications?',
                                                        'If raw materials are accepted on certificates of analysis, have suppliers been appropriately certified or qualified, have results on the COA been verified by in-house testing, and is periodic monitoring performed?',
                                                        'Are raw materials approved before being used in production?',
                                                        'If raw materials are accepted on certificates of analysis, is at least an identification test performed (where safe) on every batch and receipt?',
                                                        'Is there an effective system for monitoring and retesting or re-evaluating stored raw materials to assure that they are not used beyond their recommended use date?',
                                                        'Is there any material in reject area? Check the record of the same.',
                                                        'If fresh and recovered solvents are commingled, are the recovered solvents sampled and assayed and found to be satisfactory prior to commingling, and is the quality of commingled solvents monitored on an established schedule?',
                                                        'Is cleaning record maintained for store?',
                                                        'Is printed packing material storage separately and the same is recorded?',
                                                        'Is sampling of raw material, primary packing label, Aluminum foil & PVC / PVDC done in the LAF?',
                                                        'Checking of approved vendor list on receipt of material in the store.',
                                                        'Check the Dispensing and sampling area records.',
                                                        'Check if any stains on dispensed color/flavor poly bag which cover material.',
                                                        'Is there any product dedicated scoop for different active raw materials?',
                                                        'Check the Scoops / Spatula usage log sheet.',
                                                        'Is there clean the area of Finished Goods store? Check the record for last 3 months.',
                                                        'Check the Temperature and RH data of the Finished goods store. Check last 3 month records.',
                                                        'Do you have any record of the temperature of freeze?',
                                                        'Is there any separate location / separate method to identify the stage of raw materials?',
                                                        'Do you have any details record of dispatch for all finished goods?',
                                                        'Have you any standard practice for dispatch of finished goods?',
                                                    ];
                                                @endphp
                                            
                                                @if (!empty($data->checklist11))
                                                    <div class="inner-block">
                                                        <div class="content-table">
                                                            <!-- <div class="border-table"> -->
                                                            <div class="block-head">
                                                                Checklist - Stores
                                                            </div>
                                                            <div>
                                                                @php
                                                                    $checklists = [
                                                                        [
                                                                            'title' => 'Checklist for Stores',
                                                                            'questions' => $questions_stores,
                                                                            'prefix' => 1,
                                                                        ],
                                                                    ];
                                                                @endphp
                                            
                                                                @foreach ($checklists as $checklist)
                                                                    <div class="block"
                                                                        style="color: #4274da; display: inline-block; border-bottom: 1px solid #4274da;">
                                                                        {{ $checklist['title'] }}
                                                                    </div>
                                                                    <table class="table table-bordered">
                                                                        <thead>
                                                                            <tr>
                                                                                <th style="width: 5%;">Sr. No.</th>
                                                                                <th style="width: 40%;">Question</th>
                                                                                <th style="width: 20%;">Response</th>
                                                                                <th>Remarks</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach ($checklist['questions'] as $index => $question)
                                                                                @php
                                                                                    $response = $checklist11->{'checklist_stores_response_' . ($index + 1)};
                                                                                    $remark = $checklist11->{'checklist_stores_remark_' . ($index + 1)};
                                                                                @endphp
                                            
                                                                                <!-- Check if either response or remark is not empty -->
                                                                                @if ($response || $remark)
                                                                                    <tr>
                                                                                        <td class="flex text-center">
                                                                                            {{ $checklist['prefix'] . '.' . ($index + 1) }}</td>
                                                                                        <td>{{ $question }}</td>
                                                                                        <td>
                                                                                            <div
                                                                                                style="display: flex; justify-content: center; align-items: center; margin: 5%; gap: 5px;">
                                                                                                {{ $response }}
                                                                                            </div>
                                                                                        </td>
                                                                                        <td style="vertical-align: middle;">
                                                                                            <div style="margin: auto; display: flex; justify-content: center;">
                                                                                                {{ $remark }}
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr>
                                                                                @endif
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                @endforeach
                                                            </div>
                                                            <!-- </div> -->
                                                        </div>
                                                    </div>
                                                @endif
                                                @php
                                                    $questions_hr = [
                                                        'Do you have written procedure for material movement inside the factory premises?',
                                                        'Do the material taken out from the gate require valid gate pass at the security?',
                                                        'Do you have written procedure for visitor movement?',
                                                        'Do you have pest and rodent control procedure?',
                                                        'Whether the contract is updated?',
                                                        'Check the data for the pest & rodent control for the last 3 months, is it ok?',
                                                        'Whether the areas are marked for rodent trap & rodent gum pad? Check 4-5 points randomly.',
                                                        'Whether the rodent trap, checked for trapped rodent on daily basis & record of the same is maintained by HR, check last 3 months data.',
                                                        'Check whether any rodent is trapped in last 3 months and disposed properly?',
                                                        'Drains / Main holes are sprayed with pesticides. Check the record for the last 3 months.',
                                                        'Check the cleaning record for the road, dustbin, drain, toilet, floors, fans and tubes, canteen, tables, chairs, premises of last 3 months.',
                                                        'Do you have a written procedure for linen washing?',
                                                        'Is the linen for washing is collected from respective area in polybags?',
                                                        'Do you have written training procedure, check one training record from each department',
                                                        'Check the annual training schedule cum card for new joinee.',
                                                        'Check the operator training and record',
                                                        'Check the induction training record for one new recruit in the production, store, QA, QC.',
                                                        'Is annual medical checkup being done by a competent medical doctor?',
                                                        'Do annual medical checkup program covers tests like Hematology, urine, blood sugar, ECG, X-ray and VDRL test?',
                                                        'Is there any procedure for reporting illness such as cuts, wounds, rashes, any skin aliment, cold, cough, or any communicable diseases / infections?',
                                                        'Is there a procedure for issue, storage, washing and collection of used garments?',
                                                        'Is there any color code for garments and foot wear followed?',
                                                        'Check the linen cleaning record for last three months.',
                                                        'Whether the garments handling properly before issued.',
                                                        'Check the training record for the SOP related changes for two person for production, QA and QC',
                                                        'Do you have a laid down procedure for operation of washing machine and tumbler dryer?',
                                                        'Do you have a laid down procedure for fire prevention & control in factory premises.',
                                                        'Is there any emergency evacuation system in factory premises?',
                                                        'Check the first aid services at security gate are available or not.',
                                                        'Check the use of personnel protective equipment during critical manufacturing operation.',
                                                        'Check the canteen area is neat & clean.',
                                                        'Check the scrap record for last 2 months.',
                                                        'Checks the surrounding areas of factory are neat & clean.',
                                                        'Are you ensuring that at no stage linen of two different colors or from two different sections shall be mixed for washing?',
                                                    ];
                                                @endphp
                                            
                                                @if (!empty($data->checklist12))
                                                    <div class="inner-block">
                                                        <div class="content-table">
                                                            <!-- <div class="border-table"> -->
                                                            <div class="block-head">
                                                                Checklist - Stores
                                                            </div>
                                                            <div>
                                                                @php
                                                                    $checklists = [
                                                                        [
                                                                            'title' => 'Checklist for Human Resource',
                                                                            'questions' => $questions_hr,
                                                                            'prefix' => 1,
                                                                        ],
                                                                    ];
                                                                @endphp
                                            
                                                                @foreach ($checklists as $checklist)
                                                                    <div class="block"
                                                                        style="color: #4274da; display: inline-block; border-bottom: 1px solid #4274da;">
                                                                        {{ $checklist['title'] }}
                                                                    </div>
                                                                    <table class="table table-bordered">
                                                                        <thead>
                                                                            <tr>
                                                                                <th style="width: 5%;">Sr. No.</th>
                                                                                <th style="width: 40%;">Question</th>
                                                                                <th style="width: 20%;">Response</th>
                                                                                <th>Remarks</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach ($checklist['questions'] as $index => $question)
                                                                                @php
                                                                                    $response = $checklist12->{'checklist_hr_response_' . ($index + 1)};
                                                                                    $remark = $checklist12->{'checklist_hr_response__' . ($index + 1)};
                                                                                @endphp
                                            
                                                                                <!-- Check if either response or remark is not empty -->
                                                                                @if ($response || $remark)
                                                                                    <tr>
                                                                                        <td class="flex text-center">
                                                                                            {{ $checklist['prefix'] . '.' . ($index + 1) }}</td>
                                                                                        <td>{{ $question }}</td>
                                                                                        <td>
                                                                                            <div
                                                                                                style="display: flex; justify-content: center; align-items: center; margin: 5%; gap: 5px;">
                                                                                                {{ $response }}
                                                                                            </div>
                                                                                        </td>
                                                                                        <td style="vertical-align: middle;">
                                                                                            <div style="margin: auto; display: flex; justify-content: center;">
                                                                                                {{ $remark }}
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr>
                                                                                @endif
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                @endforeach
                                                            </div>
                                                            <!-- </div> -->
                                                        </div>
                                                    </div>
                                                @endif
                                            
                                                @php
                                                    $questions_dispensing = [
                                                        'Is access to the facility restricted?',
                                                        'Is the dispensing area cleaned as per SOP?',
                                                        'Check the status label of area and equipment.',
                                                        'Are all raw materials carry proper label?',
                                                        'Standard operating procedure for dispensing of raw material is displayed?',
                                                        'All the person involve in dispensing having proper gowning?',
                                                        'Where you keep the materials after dispensing?',
                                                        'Is there any log book for keeping the record of dispensing?',
                                                        'Have you any standard practice to cross check the approved status of raw materials before dispensing?',
                                                        'Are all balances calibrated which are to be use for dispensing?',
                                                        'Is the pressure differential of RLAF is within acceptance limit? What is the limit? _______',
                                                        'Is the pressure differential of the area is within acceptance limit? Check the pressure differential__________',
                                                        'Is there any record for room temperature & relative humidity? Check the temperature _____°C & RH _____%',
                                                    ];
                                            
                                                    $questions_visual_inspection = [
                                                        'Is status labels displayed on all equipments?',
                                                        'Equipment cleanliness, check few equipments.',
                                                        'Are machine surfaces that contact materials or finished goods, non–reactive, non-absorptive and non – additive so as not to affect the product?',
                                                        'Are there data to show that cleaning procedures for non-dedicated equipment are adequate to remove the previous materials? For active ingredients, have these procedures been validated?',
                                                        'Do you have written procedures for the safe and correct use of cleaning and sanitizing agents? What are the sanitizing agents used in this plant?',
                                                        'Are there data to show that the residues left by the cleaning and/or sanitizing agent are within acceptable limits when cleaning is performed in accordance with the approved method?',
                                                        'Do you have written procedures that describe the sufficient details of the cleaning schedule, methods, equipment and material? Check for procedure compliance',
                                                        'Are there written instructions describing how to use in-process data to control the process?',
                                                        'Are all piece of equipment clearly identified with easily visible markings? Check the equipment nos. corresponds to an entry in a log book.',
                                                        'Is equipment inspected immediately prior to use?',
                                                        'Do cleaning instructions include disassembly and drainage procedure, if required to ensure that no cleaning solutions or rinse remains in the equipment?',
                                                        'Has a written schedule been established and is it followed for cleaning of equipment?',
                                                        'Are seams on product-contact surfaces smooth and properly maintained to minimize accumulation of product, dirt, and organic matter and to avoid growth of microorganisms?',
                                                        'Is clean equipment clearly identified as “cleaned” with a cleaning date shown on the equipment tag? Check for few equipments.',
                                                        'Is equipment cleaned promptly after use?',
                                                        'Is there proper storage of cleaned equipment so as to prevent contamination?',
                                                        'Is there adequate system to assure that unclean equipment and utensils are not used (e.g., labeling with clean status)?',
                                                        'Is sewage, trash and other reuse disposed off in a safe and sanitary manner (and with sufficient frequency)',
                                                        'Are written records maintained on equipment cleaning, sanitizing and maintenance on or near each piece of equipment? Check 2 equipment records.',
                                                        'Are all weighing and measuring performed by one qualified person and checked by a second person Check the weighing balance record',
                                                        'All the person working in manufacturing area having proper gowning?',
                                                        'Is the Mfg tank calibrated?',
                                                        'Check the CIP-SIP system in place and verify the records.',
                                                        'Is the pressure differential of every particular area are within limit?',
                                                        'Is there a define procedure for filtration and verify the records.',
                                                        'Is there any procedure to carryout integrity test of the filter used in process?',
                                                        'Is there any procedure for cleaning of filling machine?',
                                                        'Is there any procedure to expose the settle plate during complete filling activity?',
                                                        'Have you any SOP regarding Hold time of material during staging?',
                                                        'Is there a written procedure specifying the frequency of inspection and replacement for air filters?',
                                                        'Are written operating procedures available for each piece of equipment used in the manufacturing, processing? Check for SOP compliance. Check the list of equipment and equipment details.',
                                                        'Does each piece of equipment have written instructions for maintenance that includes a schedule for maintenance?',
                                                        'Does the process control address all issues to ensure identity, strength, quality and purity of product?',
                                                        'Check the calibration labels for instrument calibration status',
                                                        'Temperature & RH record log book is available for each staging area.',
                                                        'Is there any procedure for operation and cleaning of tunnel, verify the records',
                                                        'Check is there any sop for operations & cleaning of autoclave verify the records.',
                                                        'Is there any procedure for operation and cleaning of washing machine, verify the records.',
                                                        'Is there any procedure for operation and cleaning of leak test apparatus, verify the records.',
                                                        'Is there any procedure for operation and cleaning of ampoule visual inspection machine, verify the records.',
                                                        'Check for area activity record',
                                                        'Check for equipment usage record',
                                                        'Check for general equipment details and accessory details.',
                                                        'Check for man & material movement in the area',
                                                        'Air handling system qualification, cleaning details and PAO test reports',
                                                        'Check for WFI hose pipe status and water hold up.',
                                                        'Check for the status labeling in the area and, material randomly',
                                                        'Check the in-process equipments cleaning status & records.',
                                                        'Have you any SOP regarding Hold time of material during staging?',
                                                    ];
                                            
                                                    $questions_documentation = [
                                                        'Do records have doer & checker signatures? Check the timings, date and yield etc in the batch production record.',
                                                        'Is each batch assigned a distinctive code, so that material can be traced through manufacturing and distribution? Check for In process analytical reports',
                                                        'Is the batch record is on line up to the current stage of a process?',
                                                        'In process carried out as per the written instruction describe in batch record?',
                                                        'Is there any area cleaning record available for all individual areas?',
                                                        'Current version of SOP’s is available in respective areas?',
                                                    ];
                                                @endphp
                                                @if (!empty($data->checklist13))
                                                    <div class="inner-block">
                                                        <div class="content-table">
                                                            <!-- <div class="border-table"> -->
                                                            <div class="block-head">
                                                                Checklist - Production (Injection Dispensing & Manufacturing)
                                                            </div>
                                                            <div>
                                                                @php
                                                                    $checklists = [
                                                                        [
                                                                            'title' => 'Checklist for Human Resource',
                                                                            'questions' => $questions_dispensing,
                                                                            'prefix' => 1,
                                                                        ],
                                                                        [
                                                                            'title' => 'Checklist for Building Facility',
                                                                            'questions' => $questions_visual_inspection,
                                                                            'prefix' => 2,
                                                                        ],
                                                                        [
                                                                            'title' => 'Checklist for HVAC/HEPA',
                                                                            'questions' => $questions_documentation,
                                                                            'prefix' => 3,
                                                                        ],
                                                                    ];
                                                                @endphp
                                            
                                                                @foreach ($checklists as $checklist)
                                                                    <div class="block"
                                                                        style="color: #4274da; display: inline-block; border-bottom: 1px solid #4274da;">
                                                                        {{ $checklist['title'] }}
                                                                    </div>
                                                                    <table class="table table-bordered">
                                                                        <thead>
                                                                            <tr>
                                                                                <th style="width: 5%;">Sr. No.</th>
                                                                                <th style="width: 40%;">Question</th>
                                                                                <th style="width: 20%;">Response</th>
                                                                                <th>Remarks</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach ($checklist['questions'] as $index => $question)
                                                                                @php
                                                                                    $response = $checklist13->{'response_dispensing_' . ($index + 1)};
                                                                                    $remark = $checklist13->{'remark_dispensing_' . ($index + 1)};
                                                                                @endphp
                                            
                                                                                <!-- Check if either response or remark is not empty -->
                                                                                @if ($response || $remark)
                                                                                    <tr>
                                                                                        <td class="flex text-center">
                                                                                            {{ $checklist['prefix'] . '.' . ($index + 1) }}</td>
                                                                                        <td>{{ $question }}</td>
                                                                                        <td>
                                                                                            <div
                                                                                                style="display: flex; justify-content: center; align-items: center; margin: 5%; gap: 5px;">
                                                                                                {{ $response }}
                                                                                            </div>
                                                                                        </td>
                                                                                        <td style="vertical-align: middle;">
                                                                                            <div style="margin: auto; display: flex; justify-content: center;">
                                                                                                {{ $remark }}
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr>
                                                                                @endif
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                @endforeach
                                                            </div>
                                                            <!-- </div> -->
                                                        </div>
                                                    </div>
                                                @endif
                                                @php
                                                    $questions_injection_packing = [
                                                        'Is status labels displayed on all equipments/machines?',
                                                        'Equipment cleanliness, check few equipments.',
                                                        'Are machine surfaces that contact materials or finished goods, non–reactive, non-absorptive and non – additive so as not to affect the product?',
                                                        'Are there data to show that cleaning procedures for non-dedicated equipment are adequate to remove the previous materials? For active ingredients, have these procedures been validated?',
                                            
                                                        'Do you have written procedures for the safe and correct use of cleaning and sanitizing agents? What are the sanitizing agents used in this plant?',
                                                        'Are there data to show that the residues left by the cleaning and/or sanitizing agent are within acceptable limits when cleaning is performed in accordance with the approved method?',
                                                        'Do you have written procedures that describe the sufficient details of the cleaning schedule, methods, equipment and material? Check for procedure compliance',
                                                        'Are there written instructions describing how to use in-process data to control the process?',
                                                        'Are all piece of equipment clearly identified with easily visible markings? Check the equipment nos. corresponds to an entry in a log book.',
                                            
                                                        'Is equipment inspected immediately prior to use?',
                                                        'Do cleaning instructions include disassembly and drainage procedure, if required to ensure that no cleaning solutions or rinse remains in the equipment?',
                                                        'Has a written schedule been established and is it followed for cleaning of equipment?',
                                                        'Are seams on product-contact surfaces smooth and properly maintained to minimize accumulation of product, dirt, and organic matter and to avoid growth of microorganisms?',
                                                        'Is clean equipment clearly identified as “cleaned” with a cleaning date shown on the equipment tag? Check for few equipments',
                                            
                                                        'Is equipment cleaned promptly after use?',
                                                        'Is there adequate system to assure that unclean equipment and utensils are not used (e.g., labeling with clean status)?',
                                                        'Is sewage, trash and other reuse disposed off in a safe and sanitary manner (and with sufficient frequency)',
                                            
                                                        'Are written records maintained on equipment cleaning, sanitizing and maintenance on or near each piece of equipment? Check 2 equipment records.',
                                            
                                                        'Are all weighing and measuring performed by one qualified person and checked by a second person',
                                            
                                                        'All the person working in manufacturing area having proper gowning?',
                                                        'Have you any SOP regarding Hold time of material during staging?',
                                                        'Is there a written procedure specifying the frequency of inspection and replacement for air filters?',
                                                        'Check for area activity record',
                                                        'Check for equipment usage record',
                                                        'Check for general equipment details and accessory details.',
                                                        'Check for man & material movement in the area',
                                                        'Air handling system qualification, cleaning details and PAO test reports',
                                                        'Check for the status labeling in the area and, material randomly',
                                                        'Check the in-process equipments cleaning status & records.',
                                                        'Are any unplanned process changes (process excursions) documented in the batch record?',
                                                        'Status label of area & equipment available?',
                                                        'Have you any proper storage area for primary and secondary packing material?',
                                                        'Do you have proper segregation system for keeping product/batch separately?',
                                                        'Stereo impression record available? Check the record for any 2 batches.',
                                                        'Where you keep the rejected ampoule / cartons?',
                                                        'Is there any standard practice for destruction of printed ampoule label & printed cartons?',
                                                        'Is there a written procedure for clearing the packaging area after one packaging operation, and cleaning before the next operation, especially if the area is used for packaging different materials?',
                                                        'Is there any procedure for operation and cleaning of ampoule label machine, verify the record',
                                                        'Is there any procedure for operation and cleaning of ampoule blister machine, verify the record.',
                                                        'Have you any standard procedure for removal of scrap?',
                                                        'Is there any procedure to cross verify the dispensed packaging material before starting the packaging.',
                                                    ];
                                            
                                                    $questions_documentation = [
                                                        'Do records have doer & checker signatures? Check the timings, date and yield etc in the batch production record.',
                                                        'Is each batch assigned a distinctive code, so that material can be traced through manufacturing and distribution? Check for In process analytical reports',
                                                        'Is the batch record is on line up to the current stage of a process?',
                                                        'In process carried out as per the written instruction describe in batch record?',
                                                        'Is there any area cleaning record available for all individual areas?',
                                                        'Current version of SOP’s is available in respective areas?',
                                                    ];
                                                @endphp
                                            
                                                @if (!empty($data->checklist14))
                                                    <div class="inner-block">
                                                        <div class="content-table">
                                                            <!-- <div class="border-table"> -->
                                                            <div class="block-head">
                                                                Checklist -Production (Injection Packing)
                                            
                                                            </div>
                                                            <div>
                                                                @php
                                                                    $checklists = [
                                                                        [
                                                                            'title' => 'Checklist for Injection Packing',
                                                                            'questions' => $questions_injection_packing,
                                                                            'prefix' => 1,
                                                                        ],
                                                                        [
                                                                            'title' => 'Checklist for Building Facility',
                                                                            'questions' => $questions_documentation,
                                                                            'prefix' => 2,
                                                                        ],
                                                                    ];
                                                                @endphp
                                            
                                                                @foreach ($checklists as $checklist)
                                                                    <div class="block"
                                                                        style="color: #4274da; display: inline-block; border-bottom: 1px solid #4274da;">
                                                                        {{ $checklist['title'] }}
                                                                    </div>
                                                                    <table class="table table-bordered">
                                                                        <thead>
                                                                            <tr>
                                                                                <th style="width: 5%;">Sr. No.</th>
                                                                                <th style="width: 40%;">Question</th>
                                                                                <th style="width: 20%;">Response</th>
                                                                                <th>Remarks</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach ($checklist['questions'] as $index => $question)
                                                                                @php
                                                                                    $response = $checklist14->{'response_injection_packing_' . ($index + 1)};
                                                                                    $remark = $checklist14->{'remark_injection_packing_' . ($index + 1)};
                                                                                @endphp
                                            
                                                                                <!-- Check if either response or remark is not empty -->
                                                                                @if ($response || $remark)
                                                                                    <tr>
                                                                                        <td class="flex text-center">
                                                                                            {{ $checklist['prefix'] . '.' . ($index + 1) }}</td>
                                                                                        <td>{{ $question }}</td>
                                                                                        <td>
                                                                                            <div
                                                                                                style="display: flex; justify-content: center; align-items: center; margin: 5%; gap: 5px;">
                                                                                                {{ $response }}
                                                                                            </div>
                                                                                        </td>
                                                                                        <td style="vertical-align: middle;">
                                                                                            <div style="margin: auto; display: flex; justify-content: center;">
                                                                                                {{ $remark }}
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr>
                                                                                @endif
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                @endforeach
                                                            </div>
                                                            <!-- </div> -->
                                                        </div>
                                                    </div>
                                                @endif
                                            
                                                @php
                                                    $questions_powder_manufacturing_filling = [
                                                        'Is status labels displayed on all equipments?',
                                                        'Equipment cleanliness, check few equipments.',
                                                        'Are machine surfaces that contact materials or finished goods, non–reactive, non-absorptive and non–additive so as not to affect the product?',
                                                        'Are there data to show that cleaning procedures for non-dedicated equipment are adequate to remove the previous materials? For active ingredients, have these procedures been validated?',
                                                        'Do you have written procedures for the safe and correct use of cleaning and sanitizing agents? What are the sanitizing agents used in this plant?',
                                                        'Are there data to show that the residues left by the cleaning and/or sanitizing agent are within acceptable limits when cleaning is performed in accordance with the approved method?',
                                                        'Do you have written procedures that describe the sufficient details of the cleaning schedule, methods, equipment and material? Check for procedure compliance',
                                                        'Are there written instructions describing how to use in-process data to control the process?',
                                                        'Are all piece of equipment clearly identified with easily visible markings? Check the equipment nos. corresponds to an entry in a log book.',
                                                        'Is equipment inspected immediately prior to use?',
                                                        'Do cleaning instructions include disassembly and drainage procedure, if required to ensure that no cleaning solutions or rinse remains in the equipment?',
                                                        'Has a written schedule been established and is it followed for cleaning of equipment?',
                                                        'Are seams on product-contact surfaces smooth and properly maintained to minimize accumulation of product, dirt, and organic matter and to avoid growth of microorganisms?',
                                                        'Is clean equipment clearly identified as “cleaned” with a cleaning date shown on the equipment tag? Check for few equipments',
                                                        'Is equipment cleaned promptly after use?',
                                                        'Is there proper storage of cleaned equipment so as to prevent contamination?',
                                                        'Is there adequate system to assure that unclean equipment and utensils are not used (e.g., labeling with clean status)?',
                                                        'Is sewage, trash and other reuse disposed off in a safe and sanitary manner (and with sufficient frequency)?',
                                                        'Are written records maintained on equipment cleaning, sanitizing and maintenance on or near each piece of equipment? Check 2 equipment records.',
                                                        'Are all weighing and measuring performed by one qualified person and checked by a second person? Check the weighing balance record',
                                                        'Are the sieves & screen kept in proper place with proper label?',
                                                        'Is the pressure differential of every particular area within limit?',
                                                        'All the person working in manufacturing area having proper gowning?',
                                                        'Have you any SOP regarding Hold time of material during staging?',
                                                        'Is there a written procedure specifying the frequency of inspection and replacement for air filters?',
                                                        'Are written operating procedures available for each piece of equipment used in the manufacturing, processing? Check for SOP compliance. Check the list of equipment and equipment details.',
                                                        'Does each piece of equipment have written instructions for maintenance that includes a schedule for maintenance?',
                                                        'Does the process control address all issues to ensure identity, strength, quality and purity of product?',
                                                        'Check the calibration labels for instrument calibration status',
                                                        'Temperature & RH record log book is available for each staging area.',
                                                        'Check for area activity record.',
                                                        'Check for equipment usage record',
                                                        'Check for general equipment details and accessory details.',
                                                        'Check for man & material movement in the area',
                                                        'Air handling system qualification, cleaning details and PAO test reports',
                                                        'Check for purified water hose pipe status and water hold up.',
                                                        'Check for the status labeling in the area and, material randomly',
                                                        'Check the in-process equipments cleaning status & records.',
                                                        'Are any unplanned process changes (process excursions) documented in the batch record?',
                                                        'If the product is blended, are there blending parameters and/or homogeneity specifications?',
                                                        'Are materials and equipment clearly labeled as to identity and, if appropriate, stage of manufacture?',
                                                        'Is there a preventive maintenance program for all equipment and status of it?',
                                                        'Do you have any SOP for operation of pouch filling and sealing machine?',
                                                        'Have you any usage logbook for powder filling and sealing machine.',
                                                    ];
                                            
                                                    $questions_packing_manufacturing = [
                                                        'Status label of area & equipment available?',
                                                        'Have you any proper storage area for primary and secondary packing material?',
                                                        'Do you have proper segregation system for keeping product/batch separately?',
                                                        'Where you keep the rejected strips / blisters / containers / cartons? ',
                                                        'Is there a written procedure for clearing the packaging area after one packaging operation, and cleaning before the next operation, especially if the area is used for packaging different materials?',
                                                        'Have you any standard procedure for removal of scrap?',
                                                    ];
                                                    $questions_documentation = [
                                                        'Do records have doer & checker signatures? Check the timings, date and yield etc in the batch packing record.',
                                                        'Is each batch assigned a distinctive code, so that material can be traced through manufacturing and distribution? Check for In process analytical reports.',
                                                        'Is the batch record is on line up to the current stage of a process?',
                                                        'In process carried out as per the written instruction describe in batch record?',
                                                        'Is there any area cleaning record available for all individual areas?',
                                                        "Current version of SOP's is available in respective areas?",
                                                    ];
                                                @endphp
                                                
                                                @if (!empty($data->checklist15))
                                                    <div class="inner-block">
                                                        <div class="content-table">
                                                            <!-- <div class="border-table"> -->
                                                            <div class="block-head">
                                                                Checklist - Production (Powder Manufacturing and Packing)
                                            
                                                            </div>
                                                            <div>
                                                                @php
                                                                    $checklists = [
                                                                        [
                                                                            'title' => 'STAGE 1 : POWEDER MFG & FILLING',
                                                                            'questions' => $questions_powder_manufacturing_filling,
                                                                            'prefix' => 1,
                                                                        ],
                                                                        [
                                                                            'title' => 'STAGE 2: PACKING',
                                                                            'questions' => $questions_packing_manufacturing,
                                                                            'prefix' => 2,
                                                                        ],
                                                                        [
                                                                            'title' => 'STAGE 3: DOCUMENTATION ',
                                                                            'questions' => $powder_questions_packing_manufacturing,
                                                                            'prefix' => 2,
                                                                        ],
                                                                    ];
                                                                @endphp
                                            
                                                                @foreach ($checklists as $checklist)
                                                                    <div class="block"
                                                                        style="color: #4274da; display: inline-block; border-bottom: 1px solid #4274da;">
                                                                        {{ $checklist['title'] }}
                                                                    </div>
                                                                    <table class="table table-bordered">
                                                                        <thead>
                                                                            <tr>
                                                                                <th style="width: 5%;">Sr. No.</th>
                                                                                <th style="width: 40%;">Question</th>
                                                                                <th style="width: 20%;">Response</th>
                                                                                <th>Remarks</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach ($checklist['questions'] as $index => $question)
                                                                                @php
                                                                                    $response =
                                                                                        $checklist15->{'response_powder_manufacturing_filling_' . ($index + 1)};
                                                                                    $remark = $checklist15->{'remark_powder_manufacturing_filling_' . ($index + 1)};
                                                                                @endphp
                                            
                                                                                <!-- Check if either response or remark is not empty -->
                                                                                @if ($response || $remark)
                                                                                    <tr>
                                                                                        <td class="flex text-center">
                                                                                            {{ $checklist['prefix'] . '.' . ($index + 1) }}</td>
                                                                                        <td>{{ $question }}</td>
                                                                                        <td>
                                                                                            <div
                                                                                                style="display: flex; justify-content: center; align-items: center; margin: 5%; gap: 5px;">
                                                                                                {{ $response }}
                                                                                            </div>
                                                                                        </td>
                                                                                        <td style="vertical-align: middle;">
                                                                                            <div style="margin: auto; display: flex; justify-content: center;">
                                                                                                {{ $remark }}
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr>
                                                                                @endif
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                @endforeach
                                                            </div>
                                                            <!-- </div> -->
                                                        </div>
                                                    </div>
                                                @endif
                                            
                                                @php
                                                    $questions_analytical_research_development = [
                                                        'Is there an adequate system SOP for reviewing and implementing analytical development?',
                                                        'Is Lic. Copy available?',
                                                        'Do you refer current pharmacopeias / literature search/ reference books etc. at the time of analytical development?',
                                                        'Regarding in house raw materials, do you receive method of analysis from manufacturer?',
                                                        'Do you receive working standards along with COA from manufacturer?',
                                                        'Can market / Generic sample study to be done?',
                                                        'Do you document method development analytical reports?',
                                                        'Can separate file to be prepared for each product?',
                                                        'Can comparative study be carried out with market sample?',
                                                        'Have non-compendial methods been validated, including accuracy, linearity, ruggedness and comparison with compendial methods or have compendial methods (Official) been verified to function properly in the company’s laboratories with proper documentation / SOP of same available?',
                                                        'Are FPS/STP available for finished product?',
                                                        'Are technology transfer SOP/documents available?',
                                                        // "Are stability study carried out for the product at",
                                                        '25°C / 60% RH',
                                                        '30°C / 70% RH',
                                                        '40°C / 75% RH',
                                                        'Are the stability results reviewed by a qualified, experienced person?',
                                                        'Is stability study in primary pack done for different products?',
                                                        'Laboratories – Do laboratories have adequate space and are they clean and orderly, with appropriate equipment for required tests?',
                                                        'Are instruments calibrated & labeled with date calibrated and date next calibration is due?',
                                                        'Are daily or monthly calibration verifications performed on analytical balances using a range of weights (high, middle, low) based on the operating range of the balance?',
                                                        'Check for compliance of stability data and its summary',
                                                        'Check for analytical reports?',
                                                        'Are data and calculations checked by a second person & countersigned?',
                                                        'Is there any checklist for the dossier requirement?',
                                                        'Current versions of SOPs are available in respective areas?',
                                                    ];
                                                @endphp
                                            
                                                @if (!empty($data->checklist16))
                                                    <div class="inner-block">
                                                        <div class="content-table">
                                                            <!-- <div class="border-table"> -->
                                                            <div class="block-head">
                                                                Checklist - Analytical Research and Development
                                            
                                                            </div>
                                                            <div>
                                                                @php
                                                                    $checklists = [
                                                                        [
                                                                            'title' => 'Checklist for Analytical Research and Development',
                                                                            'questions' => $questions_analytical_research_development,
                                                                            'prefix' => 1,
                                                                        ],
                                                                    ];
                                                                @endphp
                                            
                                                                @foreach ($checklists as $checklist)
                                                                    <div class="block"
                                                                        style="color: #4274da; display: inline-block; border-bottom: 1px solid #4274da;">
                                                                        {{ $checklist['title'] }}
                                                                    </div>
                                                                    <table class="table table-bordered">
                                                                        <thead>
                                                                            <tr>
                                                                                <th style="width: 5%;">Sr. No.</th>
                                                                                <th style="width: 40%;">Question</th>
                                                                                <th style="width: 20%;">Response</th>
                                                                                <th>Remarks</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach ($checklist['questions'] as $index => $question)
                                                                                @php
                                                                                    $response =
                                                                                        $checklist16->{'response_analytical_research_development_' . ($index + 1)};
                                                                                    $remark =
                                                                                        $checklist16->{'remark_analytical_research_development_' . ($index + 1)};
                                                                                @endphp
                                            
                                                                                <!-- Check if either response or remark is not empty -->
                                                                                @if ($response || $remark)
                                                                                    <tr>
                                                                                        <td class="flex text-center">
                                                                                            {{ $checklist['prefix'] . '.' . ($index + 1) }}</td>
                                                                                        <td>{{ $question }}</td>
                                                                                        <td>
                                                                                            <div
                                                                                                style="display: flex; justify-content: center; align-items: center; margin: 5%; gap: 5px;">
                                                                                                {{ $response }}
                                                                                            </div>
                                                                                        </td>
                                                                                        <td style="vertical-align: middle;">
                                                                                            <div style="margin: auto; display: flex; justify-content: center;">
                                                                                                {{ $remark }}
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr>
                                                                                @endif
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                            
                                                @endif
                                            
                                            
                                                @php
                                                    $questions_formulation_research_development = [
                                                        'Is there an adequate system for reviewing and implementing development?',
                                                        'Is any product development checklist?',
                                                        'Is Lic Copy available?',
                                                        'Are refer current pharmacopoeia at the time of development?',
                                                        'Can Market sample/Generic Sample Study to be done?',
                                                        'Can tooling and change part availability to be checked before initiating development?',
                                                        'Can validation be performed for IH products?',
                                                        'Is MFR-RM BOM available?',
                                                        'Is PDR available (Product development Report)?',
                                                        'Is FD involved in the change control process?',
                                                        'Is Technology transfer SOP available?',
                                                        'Can separate file be prepared for each product?',
                                                        'Can comparative study be carried out with market sample?',
                                                        'If raw materials are accepted on certificates of analysis, have suppliers been appropriately certified or qualified, have results on the COA been verified by in-house testing?',
                                                        'Are these stability chambers available to carry out stability of the product at -',
                                                        '25°C / 60% Rh',
                                                        '30°C / 65% Rh',
                                                        '40°C / 75% Rh',
                                                        'Do you keep both hard copy and electronic copy of temperature/RH monitoring?',
                                                        'Are the stability results reviewed by a qualified, experienced person?',
                                                        'Is stability study in primary pack done for different products?',
                                                        'Is any checklist for the dossier requirement?',
                                                        'Current version of SOP’s is available in respective areas?',
                                                    ];
                                                @endphp
                                            
                                                @if (!empty($data->checklist17))
                                                    <div class="inner-block">
                                                        <div class="content-table">
                                                            <div class="block-head">
                                                                Checklist - Formulation Research and Development
                                                            </div>
                                                            @php
                                                                $checklists = [
                                                                    [
                                                                        'title' => 'Checklist for Formulation Research and Development',
                                                                        'questions' => $questions_formulation_research_development,
                                                                        'prefix' => 1,
                                                                    ],
                                                                ];
                                                            @endphp
                                            
                                                            @foreach ($checklists as $checklist)
                                                                <div class="block"
                                                                    style="color: #4274da; display: inline-block; border-bottom: 1px solid #4274da;">
                                                                    {{ $checklist['title'] }}
                                                                </div>
                                                                <table class="table table-bordered">
                                                                    <thead>
                                                                        <tr>
                                                                            <th style="width: 5%;">Sr. No.</th>
                                                                            <th style="width: 40%;">Question</th>
                                                                            <th style="width: 20%;">Response</th>
                                                                            <th>Remarks</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach ($checklist['questions'] as $index => $question)
                                                                            @php
                                                                                $response =
                                                                                    $checklist17->{'response_formulation_research_development_' . ($index + 1)};
                                                                                $remark = $checklist17->{'remark_formulation_research_development_' . ($index + 1)};
                                                                            @endphp
                                            
                                                                            <!-- Check if either response or remark is not empty -->
                                                                            @if ($response || $remark)
                                                                                <tr>
                                                                                    <td class="flex text-center">{{ $checklist['prefix'] . '.' . ($index + 1) }}
                                                                                    </td>
                                                                                    <td>{{ $question }}</td>
                                                                                    <td>
                                                                                        <div
                                                                                            style="display: flex; justify-content: center; align-items: center; margin: 5%; gap: 5px;">
                                                                                            {{ $response }}
                                                                                        </div>
                                                                                    </td>
                                                                                    <td style="vertical-align: middle;">
                                                                                        <div style="margin: auto; display: flex; justify-content: center;">
                                                                                            {{ $remark }}
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                            @endif
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            @endforeach
                                                        </div>
                                                        <!-- </div> -->
                                                    </div>
                                                    </div>
                                                @endif
                                            
                                            
                                            
                                            
                                            
                                                <div class="inner-block">
                                                    <div class="content-table">
                                                        <div class="block">
                                                            <div class="block-head">
                                                                Activity log
                                                            </div>
                                                            <table>
                                                                <tr>
                                                                    <th class="w-20">Audit Schedule By</th>
                                                                    <td class="w-30">{{ $data->audit_schedule_by }}</td>
                                                                    <th class="w-20">Audit Schedule  On</th>
                                                                    <td class="w-30">{{ Helpers::getdateFormat($data->audit_schedule_on) }}</td>
                                                                    {{-- <th class="w-20"> Schedule Audit Comment</th>
                                                                    <td class="w-30">{{ $data->sheduled_audit_comment }}</td> --}}
                                                                </tr>
                                                                <tr>
                                                                    <th class="w-20">Cancelled By</th>
                                                                    <td class="w-30">{{ $data->cancelled_by }}</td>
                                                                    <th class="w-20">Cancelled On</th>
                                                                    <td class="w-30">{{ Helpers::getdateFormat($data->cancelled_on) }}</td>
                                                                    {{-- <th class="w-20"> Cancelled Comment</th>
                                                                    <td class="w-30">{{ $data->cancel_2_comment }}</td> --}}
                                                                </tr>
                                                                <tr>
                                                                    <th class="w-20">Audit Preparation Completed By by</th>
                                                                    <td class="w-30">{{ $data->audit_preparation_completed_by }}</td>
                                                                    <th class="w-20">Audit Preparation Completed By On</th>
                                                                    <td class="w-30">{{ Helpers::getdateFormat($data->audit_preparation_completed_on) }}</td>
                                                                    {{-- <th class="w-20"> Acknowledement Comment</th>
                                                                    <td class="w-30">{{ $data->acknowledge_commnet }}</td> --}}
                                                                </tr>
                                                                <tr>
                                                                    <th class="w-20">Audit Mgr.more Info Reqd  by</th>
                                                                    <td class="w-30">{{ $data->audit_mgr_more_info_reqd_by }}</td>
                                                                    <th class="w-20">Audit Mgr.more Info Reqd  On</th>
                                                                    <td class="w-30">{{ Helpers::getdateFormat($data->audit_mgr_more_info_reqd_on) }}</td>
                                                                    {{-- <th class="w-20"> Audit Mgr.more Info Reqd  Comment</th>
                                                                    <td class="w-30">{{ $data->more_info_2_comment }}</td> --}}
                                                                </tr>
                                                                
                                                                <tr>
                                                                    <th class="w-20">Audit Observation Submitted  By</th>
                                                                    <td class="w-30">{{ $data->audit_observation_submitted_by }}</td>
                                                                    <th class="w-20">Audit Observation Submitted  On</th>
                                                                    <td class="w-30">{{ Helpers::getdateFormat($data->audit_observation_submitted_on) }}</td>
                                                                    {{-- <th class="w-20"> Issue Report Comment</th>
                                                                    <td class="w-30">{{ $data->issue_report_comment }}</td> --}}
                                                                </tr>
                                                                <tr>
                                                                    <th class="w-20">Audit Lead More Info Reqd  By
                                                                    </th>
                                                                    <td class="w-30">{{ $data->audit_lead_more_info_reqd_by }}</td>
                                                                    <th class="w-20">Audit Lead More Info Reqd  On</th>
                                                                    <td class="w-30">{{ Helpers::getdateFormat($data->audit_lead_more_info_reqd_on) }}</td>
                                                                    {{-- <th class="w-20"> More Info Required Comment</th>
                                                                    <td class="w-30">{{ $data->more_info_3_comment }}</td> --}}
                                                                </tr>
                                                                
                                                                <tr>
                                                                    <th class="w-20">Audit Response Completed By</th>
                                                                    <td class="w-30">{{ $data->audit_response_completed_by }}</td>
                                                                    <th class="w-20">
                                                                        Audit Response Completed On</th>
                                                                    <td class="w-30">{{ Helpers::getdateFormat($data->audit_response_completed_on) }}</td>
                                                                    {{-- <th class="w-20"> CAPA Plan Proposed Comment</th>
                                                                    <td class="w-30">{{ $data->capa_plan_comment }}</td> --}}
                                            
                                                                </tr>
                                                                <tr>
                                                                    <th class="w-20">Response Feedback Verified By</th>
                                                                    <td class="w-30">{{ $data->response_feedback_verified_by }}</td>
                                                                    <th class="w-20">
                                                                        Response Feedback Verified On</th>
                                                                    <td class="w-30">{{ Helpers::getdateFormat($data->response_feedback_verified_on) }}</td>
                                                                    {{-- <th class="w-20"> No CAPAs Required Comment</th>
                                                                    <td class="w-30">{{ $data->response_feedback_verified_required_comment }}</td> --}}
                                            
                                                                </tr>
                                                                <tr>
                                                                    <th class="w-20">Rejected By</th>
                                                                    <td class="w-30">{{ $data->rejected_by }}</td>
                                                                    <th class="w-20">
                                                                        Rejected On</th>
                                                                    <td class="w-30">{{ Helpers::getdateFormat($data->rejected_on) }}</td>
                                                                    {{-- <th class="w-20"> Response Reviewed Comment</th>
                                                                    <td class="w-30">{{ $data->response_reviewd_comment }}</td> --}}
                                            
                                                                </tr>
                                            
                                            
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            
                                            @endforeach
                                        @endif

                                        @if (count($ExternalAudit) > 0)
                                            @foreach ($ExternalAudit as $data)
                                                <center>
                                                    <h3>ExternalAudit Report</h3>
                                                </center>

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
                                                                    {{ Helpers::getDivisionName($data->division_id) }}/EA/{{ date('Y') }}/{{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}                </td>
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
                                                                    <th class="w-20">Initiator Group</th>
                                                                    <td class="w-30">  @if($data->Initiator_Group){{ \Helpers::getInitiatorGroupFullName($data->Initiator_Group) }} @else Not Applicable @endif</td>
                                                                    <th class="w-20">Initiator Group Code</th>
                                                                    <td class="w-30">@if($data->initiator_group_code){{ $data->initiator_group_code }} @else Not Applicable @endif</td>
                                                                </tr>
                                            
                                                                <tr>
                                                                    <th class="w-20">Short Description</th>
                                                                    <td class="w-30"> @if($data->short_description){{ $data->short_description }}@else Not Applicable @endif</td>
                                                                </tr>
                                                                <tr>
                                                                    <!-- <th class="w-20">Site/Location Code</th>
                                                                    <td class="w-30">@if($data->division_code){{ $data->division_code }} @else Not Applicable @endif</td> -->
                                                                    <th class="w-20">Initiated Through</th>
                                                                    <td class="w-30">@if($data->initiated_through){{ $data->initiated_through }} @else Not Applicable @endif</td>
                                                                 
                                                                    <th class="w-20"> Severity Level</th>
                                                                    <td class="w-30">@if($data->severity_level){{ $data->severity_level }} @else Not Applicable @endif</td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="w-20">Audit type</th>
                                                                    <td class="w-30">@if($data->audit_type){{ $data->audit_type }}@else Not Applicable @endif</td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="w-20">Others</th>
                                                                    <td class="w-30">@if($data->initiated_if_other){{ $data->initiated_if_other }} @else Not Applicable @endif</td>
                                                                    <th class="w-20">External Agencies </th>
                                                                    <td class="w-30">@if($data->external_agencies){{ $data->external_agencies }} @else Not Applicable @endif</td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="w-20">Description</th>
                                                                    <td class="w-80">@if($data->initial_comments){{ $data->initial_comments }} @else Not Applicable @endif</td>
                                                                    <th class="w-20">If Others</th>
                                                                    <td class="w-80">@if($data->if_other){{ $data->if_other }}@else Not Applicable @endif</td>                       
                                                                </tr>
                                                               
                                                                
                                                                <tr>  
                                                                   
                                                                </tr>
                                                                
                                                    
                                            
                                                            </table>
                                                            <div class="border-table">
                                                                <div class="block-head">
                                                                    Initial Attachment
                                                                </div>
                                                                <table>
                                            
                                                                    <tr class="table_bg">
                                                                        <th class="w-20">S.N.</th>
                                                                        <th class="w-60">Batch No</th>
                                                                    </tr>
                                                                        @if($data->inv_attachment)
                                                                        @foreach(json_decode($data->inv_attachment) as $key => $file)
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
                                                        
                                            
                                            
                                                        <div class="block">
                                                            <div class="head">
                                                                <div class="block-head">
                                                                    Audit Planning
                                                                </div>
                                                                <table>
                                                                    <tr>
                                                                        <th class="w-20">Audit Schedule Start Date</th>
                                                                        <td class="w-30">@if($data->start_date){{ Helpers::getdateFormat($data->start_date) }}@else Not Applicable @endif</td>
                                                                    </tr>
                                                                    <tr>   
                                                                        <th class="w-20">Audit Schedule End Date</th>
                                                                        <td class="w-20">@if($data->end_date){{ Helpers::getdateFormat($data->end_date) }}@else Not Applicable @endif</td>
                                            
                                                                    </tr>
                                            </table>
                                                                    
                                                                <div class="block">
                                                                   <div class="block-head">
                                                                    Audit Agenda
                                                                    </div>
                                            
                                                                    <div class="border-table">
                                                                        <table>
                                                                            <tr class="table_bg">
                                                                                <th class="w-20">SR no.</th>
                                                                                <th>Area of Audit</th>
                                                                                <th>Start Date</th>
                                                                                <th>Start Time</th>
                                                                                <th>End Date</th>
                                                                                <th>End Time</th>
                                                                                <th>Auditor</th>
                                                                                <th>Auditee</th>
                                                                                <th>Remark</th>
                                                                            </tr>
                                                                            
                                                                            @php 
                                                                                $getGridata = DB::table('internal_audit_grids')->where('audit_id', $data->id)->first();
                                                                                if(!empty($getGridata)){
                                                                                    $getGridata->area_of_audit = unserialize($getGridata->area_of_audit);
                                                                                    $getGridata->start_date = unserialize($getGridata->start_date);
                                                                                    $getGridata->start_time = unserialize($getGridata->start_time);
                                                                                    $getGridata->end_date = unserialize($getGridata->end_date);
                                                                                    $getGridata->end_time = unserialize($getGridata->end_time);
                                                                                    $getGridata->auditor = unserialize($getGridata->auditor);
                                                                                    $getGridata->auditee = unserialize($getGridata->auditee);
                                                                                    $getGridata->remark = unserialize($getGridata->remark);
                                                                                }
                                                                            @endphp
                                                                            @if ($getGridata)
                                            
                                                                                @php
                                            
                                                                                
                                                                                    // Getting the maximum number of entries in any of the arrays to loop through all rows
                                                                                    $maxRows = max(
                                                                                        count($getGridata->area_of_audit ?? []),
                                                                                        count($getGridata->start_date ?? []),
                                                                                        count($getGridata->start_time ?? []),
                                                                                        count($getGridata->end_date ?? []),
                                                                                        count($getGridata->end_time ?? []),
                                                                                        count($getGridata->auditor ?? []),
                                                                                        count($getGridata->auditee ?? []),
                                                                                        count($getGridata->remark ?? [])
                                                                                    );
                                                                                @endphp
                                            
                                                                                @for ($i = 0; $i < $maxRows; $i++)
                                                                                    <tr>
                                                                                        <td>{{ $i + 1 }}</td>
                                                                                        <td>{{ $getGridata->area_of_audit[$i] ?? 'Not Applicable' }}</td>
                                                                                        <td>{{ $getGridata->start_date[$i] ?? 'Not Applicable' }}</td>
                                                                                        <td>{{ $getGridata->start_time[$i] ?? 'Not Applicable' }}</td>
                                                                                        <td>{{ $getGridata->end_date[$i] ?? 'Not Applicable' }}</td>
                                                                                        <td>{{ $getGridata->end_time[$i] ?? 'Not Applicable' }}</td>
                                                                                        <td>{{  Helpers::getInitiatorName($getGridata->auditor[$i] ?? 'Not Applicable') }}</td>
                                                                                        <td>{{  Helpers::getInitiatorName($getGridata->auditee[$i] ?? 'Not Applicable') }}</td>
                                                                                        <td>{{ $getGridata->remark[$i] ?? 'Not Applicable' }}</td>
                                                                                    </tr>
                                                                                @endfor
                                                                            @else
                                                                                <tr>
                                                                                    <td colspan="9">No Data Available</td>
                                                                                </tr>
                                                                            @endif
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            <table>
                                            
                                            
                                                                    <tr>
                                                                        <th class="w-20">Comments (If Any)</th>
                                                                        <td class="w-30">
                                                                            @if($data->if_comments)
                                                                                @foreach (explode(',', $data->if_comments) as $Key => $value)
                                            
                                                                                {{ $value }}
                                                                                @endforeach
                                                                            @else
                                                                              Not Applicable
                                                                            @endif</td>
                                                                     </tr>
                                                                        
                                                                    <tr>
                                            
                                                                            <th class="w-20">Product/Material Name</th>
                                                                            <td class="w-80">
                                                                                @if($data->material_name)
                                                                                    @foreach (explode(',', $data->material_name) as $Key => $value)
                                                                                    {{ $value }}
                                                                                    @endforeach
                                                                                @else
                                                                                  Not Applicable
                                                                                @endif</td>
                                            
                                            
                                                                    </tr>
                                            
                                                            </table>
                                                            </div>
                                                        </div>
                                                        <div class="block">
                                                            <div class="block-head">
                                                              Audit Preparation
                                                            </div>
                                                            <table>
                                                                <tr>
                                                                    <th class="w-20">Lead Auditor</th>
                                                                    <td class="w-80">
                                                                        @if($data->lead_auditor)
                                                                            {{ Helpers::getInitiatorName($data->lead_auditor) }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                            
                                                                <tr>
                                                                    <th class="w-20">Audit Team</th>
                                                                    <td class="w-80">
                                                                        @if($data->Audit_team)
                                                                            {{ $data->Audit_team }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                            
                                                                    <th class="w-20">Auditee</th>
                                                                    <td class="w-80">
                                                                        @if($data->Auditee)
                                                                            {{ $data->Auditee }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                            
                                            
                                            
                                                                <tr>
                                                                    <th class="w-20">External Auditor Details</th>
                                                                    <td class="w-80">
                                                                        @if(!empty($data->Auditor_Details))
                                                                            {{ $data->Auditor_Details }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                    </tr>
                                                                    <tr>
                                                                    <th class="w-20">External Auditing Agency</th>
                                                                    <td class="w-80">
                                                                        @if(!empty($data->External_Auditing_Agency))
                                                                            {{ $data->External_Auditing_Agency }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                            
                                            
                                                                <tr>
                                                                    <th class="w-20">Relevant Guidelines / Industry Standards</th>
                                                                    <td class="w-80">
                                                                        @if($data->Relevant_Guidelines)
                                                                            {{ $data->Relevant_Guidelines }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="w-20">QA Comments</th>
                                                                    <td class="w-80">
                                                                        @if($data->QA_Comments)
                                                                            {{ $data->QA_Comments }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                    </tr>
                                                                    
                                                                <tr>
                                                                    <th class="w-20">Audit Category</th>
                                                                    <td class="w-80">
                                                                        @if($data->Audit_Category)
                                                                            {{ $data->Audit_Category }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="w-20">Supplier/Vendor/Manufacturer Site</th>
                                                                    <td class="w-80">
                                                                        @if($data->Supplier_Site)
                                                                            {{ $data->Supplier_Site }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                    </tr>
                                                                <tr>
                                                                    <th class="w-20">Supplier/Vendor/Manufacturer Details</th>
                                                                    <td class="w-30">
                                                                        @if($data->Supplier_Details)
                                                                            {{ $data->Supplier_Details }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                              
                                                                <tr>
                                                                    <th class="w-20">Comments</th>
                                                                    <td class="w-80">
                                                                        @if($data->Comments)
                                                                            {{ $data->Comments }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            </table>
                                            
                                                        </div>
                                                        <div class="border-table">
                                                            <div class="block-head">
                                                               File Attachment
                                                            </div>
                                                            <table>
                                            
                                                                <tr class="table_bg">
                                                                    <th class="w-20">S.N.</th>
                                                                    <th class="w-60">Batch No</th>
                                                                </tr>
                                                                    @if($data->file_attachment)
                                                                    @foreach(json_decode($data->file_attachment) as $key => $file)
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
                                                        <div class="border-table">
                                                            <div class="block-head">
                                                               Guideline Attachment
                                                            </div>
                                                            <table>
                                                                <tr class="table_bg">
                                                                    <th class="w-20">S.N.</th>
                                                                    <th class="w-60">Batch No</th>
                                                                </tr>
                                                                @if($data->file_attachment && $data->file_attachment_guideline)
                                                                    @php
                                                                        $attachments = json_decode($data->file_attachment_guideline, true);
                                                                    @endphp
                                                                    @if(is_array($attachments))
                                                                        @foreach($attachments as $key => $file)
                                                                            <tr>
                                                                                <td class="w-20">{{ $key + 1 }}</td>
                                                                                <td class="w-20"><a href="{{ asset('upload/' . $file) }}" target="_blank"><b>{{ $file }}</b></a></td>
                                                                            </tr>
                                                                        @endforeach
                                                                    @else
                                                                        <tr>
                                                                            <td class="w-20">1</td>
                                                                            <td class="w-20">Invalid JSON</td>
                                                                        </tr>
                                                                    @endif
                                                                @else
                                                                    <tr>
                                                                        <td class="w-20">1</td>
                                                                        <td class="w-20">Not Applicable</td>
                                                                    </tr>
                                                                @endif
                                                            </table>
                                                            
                                                        </div>
                                                        <div class="block">
                                                            <div class="head">
                                                                <div class="block-head">
                                                                   Audit Execution
                                                                </div>
                                                                <table>
                                            
                                                                    <tr>
                                                                   
                                                                        <th class="w-20">Audit Start Date</th>
                                                                        <td class="w-30">
                                                                            <div>
                                                                                @if($data->audit_start_date){{ $data->audit_start_date }}@else Not Applicable @endif
                                                                            </div>
                                                                        </td>
                                                                        <th class="w-20">Audit End Date</th>
                                                                        <td class="w-30">
                                                                            <div>
                                                                                @if($data->audit_end_date){{ $data->audit_end_date }}@else Not Applicable @endif
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="w-20">Audit Comments
                                                                        </th>
                                                                        <td class="w-80">
                                                                            <div>
                                                                                @if($data->Audit_Comments1){{ $data->Audit_Comments1 }}@else Not Applicable @endif
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                            
                                            
                                                            <div class="block">
                                                <div class="block-head">
                                                Observation Details 
                                                </div>
                                            
                                                <div class="border-table">
                                                    <table>
                                                        <tr class="table_bg">
                                                            <th class="w-20">SR no.</th>
                                                            <th>Observation Details</th>
                                                            <th>Pre Comments</th>
                                                            <th>CAPA Details if any</th>
                                                            <th>Post Comments</th>
                                                        </tr>
                                            
                                                        @php 
                                                            $getGridata_1 = DB::table('internal_audit_grids')->where(['audit_id' => $data->id, 'type' => "Observation_field_Auditee"])->first();
                                            
                                                            if (!empty($getGridata_1)) {
                                                                $getGridata_1->observation_id = unserialize($getGridata_1->observation_id) ?: [];
                                                                $getGridata_1->observation_description = unserialize($getGridata_1->observation_description) ?: [];
                                                                $getGridata_1->area = unserialize($getGridata_1->area) ?: [];
                                                                $getGridata_1->auditee_response = unserialize($getGridata_1->auditee_response) ?: [];
                                                            }
                                                        @endphp
                                            
                                                        @if ($getGridata_1)
                                                            @php
                                                          //  dd($getGridata_1);
                                                                // Getting the maximum number of entries in any of the arrays to loop through all rows
                                                                $maxRows = max(
                                                                    count($getGridata_1->observation_id),
                                                                    count($getGridata_1->observation_description),
                                                                    count($getGridata_1->area),
                                                                    count($getGridata_1->auditee_response)
                                                                );
                                                            @endphp
                                            
                                                            @for ($i = 0; $i < $maxRows; $i++)
                                                                <tr>
                                                                    <td>{{ $i + 1 }}</td>
                                                                    <td>{{ $getGridata_1->observation_id[$i] ?? 'Not Applicable' }}</td>
                                                                    <td>{{ $getGridata_1->observation_description[$i] ?? 'Not Applicable' }}</td>
                                                                    <td>{{ $getGridata_1->area[$i] ?? 'Not Applicable' }}</td>
                                                                    <td>{{ $getGridata_1->auditee_response[$i] ?? 'Not Applicable' }}</td>
                                                                </tr>
                                                            @endfor
                                                        @else
                                                            <tr>
                                                                <td colspan="5">No Data Available</td>
                                                            </tr>
                                                        @endif
                                                    </table>
                                                </div>
                                            </div>
                                                            <div class="border-table">
                                                                <div class="block-head">
                                                                    Audit Attachments
                                                                </div>
                                                                <table>
                                            
                                                                    <tr class="table_bg">
                                                                        <th class="w-20">S.N.</th>
                                                                        <th class="w-60">Batch No</th>
                                                                    </tr>
                                                                        @if($data->Audit_file)
                                                                        @foreach(json_decode($data->Audit_file) as $key => $file)
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
                                                        </div>
                                                    </table>
                                                </div>  
                                                            
                                                        <div class="block">
                                                            <div class="block-head">
                                                            Audit Response & Closure
                                                            </div>
                                                            <table>
                                            
                                                                    <tr>
                                                                    <th class="w-20">Reference Record</th>
                                                                    <td class="w-30">@if($data->Reference_Recores1)
                                                                        {{ Helpers::getDivisionName($data->division_id) }}/EA/{{date('Y')}}/{{ Helpers::recordFormat($data->Reference_Recores1) }}
                                                                       @else Not Applicable @endif</td>
                                                                    </tr> 
                                                                    <tr>
                                                                    
                                                                    <th class="w-20">Due Date Extension Justification</th>
                                                                    <td class="w-30">@if($data->due_date_extension){{ $data->due_date_extension }}@else Not Applicable @endif</td>
                                                                </tr>
                                                                <tr>
                                                                <th class="w-20">Remarks</th>
                                                                    <td class="w-80" colspan="3">@if($data->Remarks){{ $data->Remarks }}@else Not Applicable @endif</td>
                                                                  </tr>
                                                                  <tr>
                                                                        <th class="w-20">Audit Comments
                                                                        </th>
                                                                        <td class="w-80">
                                                                            <div>
                                                                                @if($data->Audit_Comments2){{ $data->Audit_Comments2 }}@else Not Applicable @endif
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                            
                                            
                                                                </table>
                                                            </div>
                                                            <div class="border-table">
                                                                <div class="block-head">
                                                                    Audit Attachments
                                                                </div>
                                                                <table>
                                            
                                                                    <tr class="table_bg">
                                                                        <th class="w-20">S.N.</th>
                                                                        <th class="w-60">File </th>
                                                                    </tr>
                                                                        @if($data->myfile)
                                                                        @foreach(json_decode($data->myfile) as $key => $file)
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
                                                            <div class="border-table">
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
                                                            </div>
                                                            
                                            
                                                        <div class="block">
                                                            <div class="block-head">
                                                                Activity Log
                                                            </div>
                                                            <table>
                                                                <tr>
                                                                    <th class="w-20">Audit Schedule By</th>
                                                                    <td class="w-30">{{ $data->audit_schedule_by }}</td>
                                                                    <th class="w-20">Audit Schedule On</th>
                                                                    <td class="w-30">{{ Helpers::getdateFormat($data->created_at) }}</td>
                                            
                                                                    <th class="w-20">Audit Schedule Comment</th>
                                                                    <td class="w-30">{{ $data->audit_schedule_on_comment}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="w-20">Cancelled By</th>
                                                                    <td class="w-30">{{ $data->cancelled_by}}</td>
                                                                    <th class="w-20">Cancelled On</th>
                                                                    <td class="w-30">{{ Helpers::getdateFormat($data->cancelled_on) }}</td>
                                                                    <th class="w-20">Cancelled Comment</th>
                                                                    <td class="w-30">{{ $data->cancel_1}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="w-20">Audit preparation completed by</th>
                                                                    <td class="w-30">{{ $data->audit_preparation_completed_by }}</td>
                                                                    <th class="w-20">Audit preparation completed On</th>
                                                                    <td class="w-30">{{ Helpers::getdateFormat($data->audit_preparation_completed_on) }}</td>
                                                                    <th class="w-20">Complete Audit
                                                                    Preparation Comment</th>
                                                                    <td class="w-30">{{ $data->audit_preparation_completed_on_comment }}</td>
                                                                </tr>
                                            
                                                                <tr>
                                                                    <th class="w-20">Reject by</th>
                                                                    <td class="w-30">{{ $data->rejected_by }}</td>
                                                                    <th class="w-20">Reject On</th>
                                                                    <td class="w-30">{{ Helpers::getdateFormat($data->rejected_on) }}</td>
                                                                    <th class="w-20">Reject Comment</th>
                                                                    <td class="w-30">{{ $data->audit_preparation_completed_on_comment }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="w-20">Issue Report By</th>
                                                                    <td class="w-30">{{ $data->audit_mgr_more_info_reqd_by }}</td>
                                                                    <th class="w-20">Issue Report On</th>
                                                                    <td class="w-30">{{ Helpers::getdateFormat($data->audit_mgr_more_info_reqd_on) }}</td>
                                                                    <th class="w-20">Issue Report Comment</th>
                                                                    <td class="w-30">{{ $data->audit_mgr_more_info_reqd_on_comment }}</td>
                                                                </tr>
                                            
                                                                <tr>
                                                                    <th class="w-20">Reject By</th>
                                                                    <td class="w-30">{{ $data->rejected_by_2 }}</td>
                                                                    <th class="w-20">Rejectt On</th>
                                                                    <td class="w-30">{{ Helpers::getdateFormat($data->rejected_on_2) }}</td>
                                                                    <th class="w-20">Reject Comment</th>
                                                                    <td class="w-30">{{ $data->reject_data_1 }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="w-20">CAPA Plan Proposed By</th>
                                                                    <td class="w-30">{{ $data->audit_observation_submitted_by }}</td>
                                                                    <th class="w-20">CAPA Plan Proposed On</th>
                                                                    <td class="w-30">{{ Helpers::getdateFormat($data->audit_observation_submitted_on) }}</td>
                                                                    <th class="w-20">CAPA Plan Proposed Comment</th>
                                                                    <td class="w-30">{{ $data->audit_observation_submitted_on_comment }}</td>
                                                                </tr>
                                            
                                                                <tr>
                                                                    <th class="w-20">All CAPA Closed  By</th>
                                                                    <td class="w-30">{{ $data->response_feedback_verified_by }}</td>
                                                                    <th class="w-20">All CAPA Closed  On</th>
                                                                    <td class="w-30">{{ Helpers::getdateFormat($data->response_close_done) }}</td>
                                                                    <th class="w-20">All CAPA Closed Comment</th>
                                                                    <td class="w-30">{{ $data->audit_mgr_more_info_reqd_on_comment }}</td>
                                                                </tr>
                                                                
                                            
                                            
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                        @if (count($Sanction) > 0)
                                            @foreach ($Sanction as $data)
                                                <center>
                                                    <h3>Sanction Report</h3>
                                                </center>
                                                <div class="inner-block">
                                                    <div class="content-table">
                                                        <div class="block">
                                                            <div class="block-head">
                                                                General Information
                                                            </div>
                                                            <table>
                                                                <tr>
                                                                    <th class="w-20">Record Number</th>
                                                                    <td class="w-30">{{ $data->record_number }} </td>
                                                                    <th class="w-20">Site/Location Code</th>
                                                                    <td class="w-30">
                                                                        @if ($data->division_id)
                                                                            {{ Helpers::getDivisionName($data->division_id) }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                            
                                                                <tr> {{ $data->created_at }} added by {{ $data->originator }}
                                                                    <th class="w-20">Initiator</th>
                                                                    <td class="w-30">{{ Helpers::getInitiatorName($data->initiator_id) }}</td>
                                                                    <th class="w-20">Date of Initiation</th>
                                                                    <td class="w-30">{{ Helpers::getdateFormat($data->intiation_date) }}</td>
                                                                </tr>
                                            
                                                                <tr>
                                                                    <th class="w-20">Assigned To</th>
                                                                    <td class="w-30">
                                                                        @if ($data->assign_to)
                                                                            {{ Helpers::getInitiatorName($data->assign_to) }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                    <th class="w-20">Due Date</th>
                                                                    <td class="w-30">
                                                                        @if ($data->due_date)
                                                                            {{ Helpers::getdateFormat($data->due_date) }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                            
                                                                </tr>
                                            
                                            
                                            
                                            
                                                            </table>
                                            
                                                            <label class="head-number" for="Short Description">Short Description</label>
                                                            <div class="div-data">
                                                                @if ($data->short_description)
                                                                    {{ $data->short_description }}
                                                                @else
                                                                    Not Applicable
                                                                @endif
                                                            </div>
                                            
                                                            <div class="block-head">
                                                                EHS Event Details
                                                            </div>
                                            
                                                            <table>
                                            
                                                                <tr>
                                                                    <th class="w-20">Type</th>
                                                                    <td class="w-80">
                                                                        @if ($data->Type)
                                                                            {{ $data->Type }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                            
                                                            </table>
                                            
                                                            <div class="block-head">
                                                                Attached File
                                                            </div>
                                                            <div class="border-table">
                                                                <table>
                                                                    <tr class="table_bg">
                                                                        <th class="w-20">S.N.</th>
                                                                        <th class="w-60">File </th>
                                                                    </tr>
                                                                    @if ($data->Attached_File)
                                                                        @foreach (json_decode($data->Attached_File) as $key => $file)
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
                                            
                                                            <label class="head-number" for="Description">Description</label>
                                                            <div class="div-data">
                                                                @if ($data->Description)
                                                                    {{ $data->Description }}
                                                                @else
                                                                    Not Applicable
                                                                @endif
                                                            </div>
                                            
                                                            <table>
                                            
                                                                <tr>
                                                                    <th class="w-20">Authority Type</th>
                                                                    <td class="w-80">
                                                                        @if ($data->Authority_Type)
                                                                            {{ $data->Authority_Type }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                    <th class="w-20">Authority</th>
                                                                    <td class="w-80">
                                                                        @if ($data->Authority)
                                                                            {{ $data->Authority }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                            
                                                                <tr>
                                                                    <th class="w-20">Fine</th>
                                                                    <td class="w-80">
                                                                        @if ($data->Fine)
                                                                            {{ $data->Fine }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                    <th class="w-20">Currency</th>
                                                                    <td class="w-80">
                                                                        @if ($data->Currency)
                                                                            {{ $data->Currency }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                            
                                                            </table>
                                            
                                                        </div>
                                            
                                                        <div class="block">
                                                            <div class="block-head">
                                                                Activity Log
                                                            </div>
                                                            <table>
                                                                <tr>
                                                                    <th class="w-30">Cancel By
                                                                    </th>
                                                                    <td class="w-30">
                                                                        @if ($data->Cancel_By)
                                                                            {{ $data->Cancel_By }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                    <th class="w-20">
                                                                        Cancel On</th>
                                                                    <td class="w-30">
                                                                        @if ($data->Cancel_On)
                                                                            {{ $data->Cancel_On }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                    <th class="w-20">
                                                                        Cancel Comment</th>
                                                                    <td class="w-30">
                                                                        @if ($data->Cancel_Comment)
                                                                            {{ $data->Cancel_Comment }}
                                                                        @else
                                                                            Not Applicable
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>

                                                @endforeach
                                        @endif

</body>

</html>
