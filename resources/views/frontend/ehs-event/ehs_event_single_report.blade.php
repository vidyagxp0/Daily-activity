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
        padding-left: 8px;
    }

    .div-data {
        font-size: 13px;
        padding-left: 8px;
        margin-bottom: 20px;
    }
</style>

<body>

    <header>
        <table>
            <tr>
                <td class="w-70 head">
                    EHS & Environment Sustainability Single Report
                </td>
                <td class="w-30">
                    <div class="logo">
                        <img src="https://www.cphi-online.com/Medicef%20Logo-comp306798.jpg" alt="" class="w-50">
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
                    {{ Helpers::divisionNameForQMS($data->division_id) }}/{{ date('Y') }}/CAPA/{{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}
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
                        <th class="w-20">Public Relations/Community Engagement Reports</th>
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
                        <th class="w-20">Key Performance Indicators (KPIs)</th>
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
                        <th class="w-20">Monthly/Quarterly/Annual Reports</th>
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
                        <th class="w-20">KPIs (Key Performance Indicators)</th>
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
                        <th class="w-20">Renewable Energy Usage Target (%)</th>
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
                        <th class="w-20">Carbon Footprint (Metric Tons CO2e)</th>
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
                        <th class="w-20">Percentage of Sustainable Products (%)</th>
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
                        <th class="w-20">Product Life Extension Target (%)</th>
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


</body>

</html>
