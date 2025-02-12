@extends('frontend.layout.main')
@section('container')
<br>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Record Analytics</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            text-align: left;
            padding: 8px;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
      <style>
        .table-header {
          font-weight: bold;
          font-size: 1.1rem;
          text-align: center;
          padding: 12px;
          background-color: #427CE6;
          color: white;
          border: 2px solid #bfd0f2;
          border-radius: 5px;
          width: 20px;
      }   
      
      .active-stage-row {
          font-weight: bold;
          color: #eca035;
          background-color: #fff9e5;
          animation: highlightRow 0.8s ease-in-out forwards;
      }
  
      .completed-stage-row {
          background-color: #e8f5e9;
          color: #4caf50;
          font-weight: bold;
          animation: highlightRow 0.8s ease-in-out forwards;
      }
  
      .pending-stage-row {
          background-color: #ffebee;
          color: #d32f2f;
          font-weight: bold;
          animation: highlightRow 0.8s ease-in-out forwards;
      }
  
      .table thead th {
          text-align: center;
          font-size: 1.2rem;
          padding: 10px;
      }
  
      .fa-car {
          font-size: 1.2rem;
          margin-left: 10px;
      }
  
      .status-cell {
          text-align: center;
          font-weight: bold;
      }
  
      .completed-icon {
          color: #4caf50;
      }
  
      .active-icon {
          color: #eca035;
          animation: spinner 1s infinite;
      }
  
      .pending-icon {
          color: #d32f2f;
      }
  
      @keyframes highlightRow {
          0% {
              background-color: rgba(0, 0, 0, 0);
          }
          100% {
              background-color: rgba(255, 255, 255, 0.1);
          }
      }

      @keyframes moveCar {
          0% {
              transform: translateX(0);
          }
          50% {
              transform: translateX(15px);
          }
          100% {
              transform: translateX(0);
          }
      }
      @keyframes spinner {
          0% {
              transform: rotate(0deg);
          }
          100% {
              transform: rotate(360deg);
          }
      }
  
  </style>
    <style>
        .record-analytics-heading {
            display: flex;
            align-items: center;
            font-size: 1.8rem;
            font-weight: bold;
            color: #000000; 
            margin-bottom: 20px;
            /* background-color: #000; */
            padding: 15px; 
            border: 2px solid #427CE6; 
            border-radius: 10px; 
            /* box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);  */
            text-align: center;
        }
    
        .record-analytics-heading i {
            margin-right: 10px;
            color: #427CE6;
        }
    </style>
      <style>
        .filter-form {
            background-color: #f9f9f9;
            border: 2px solid #ececec;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
    
        .filter-form .form-group label {
            font-weight: bold;
            color: #555;
        }
    
        .filter-form .form-control,
        .filter-form .custom-select {
            border-radius: 5px;
            border: 1px solid #427CE6;
        }
    
        .filter-form button {
            margin-top: 15px;
        }
    
        .btn-primary {
            background-color: #427CE6;
            border-color: #427CE6;
        }
    
        .btn-primary:hover {
            background-color: #427CE6;
            border-color: #427CE6;
        }
    
        .btn-secondary {
            background-color: #999;
            border-color: #999;
            margin-top: 15px;
        }
    
        .btn-secondary:hover {
            background-color: #888;
            border-color: #888;
        }
    
        .btn i {
            margin-right: 5px;
        }
      
        .custom-button {
        font-size: 1rem; 
        font-weight: bold; 
        color: #427CE6; 
        border-color: #bfd0f2; 
        background-color: transparent; 
        }

        .custom-button:hover {
            background-color: #bfd0f2; 
            color: #fff; 
            border-color: #427CE6; 
        }

        .mr-2 {
            margin-right: 10px; 
        }
    </style>
</head>
<body>
    <div class="container" style="max-width: 1769px;">
        <h3 class="record-analytics-heading">
            <i class="fas fa-chart-bar"></i> Record Analytics</h3>
        <br>
         <form id="filter-form" class="mb-4 p-4 filter-form" method="GET" action="{{ route('qmsRecordAnalytics') }}">
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="process">Process</label>
                    <select id="process" name="process" class="form-control custom-select">
                        <option value="">All Process</option>
                        <option value="Action Item" {{ request('process') == 'Action Item' ? 'selected' : '' }}>Action Item</option>
                        <option value="Audit Program" {{ request('process') == 'Audit Program' ? 'selected' : '' }}>Audit Program</option>
                        <option value="CAPA" {{ request('process') == 'CAPA' ? 'selected' : '' }}>CAPA</option>
                        <option value="Change Control" {{ request('process') == 'Change Control' ? 'selected' : '' }}>Change Control</option>
                        <option value="Complaint Managment" {{ request('process') == 'Complaint Managment' ? 'selected' : '' }}>Complaint Management</option>
                        <option value="Deviation" {{ request('process') == 'Deviation' ? 'selected' : '' }}>Deviation</option>
                        <option value="Due Date Extension" {{ request('process') == 'Due Date Extension' ? 'selected' : '' }}>Due Date Extension</option>
                        <option value="Effectiveness Check" {{ request('process') == 'effe' ? 'selected' : '' }}>Effectiveness Check</option>
                        <option value="EHS & Environment Sustainability" {{ request('process') == 'EHS & Environment Sustainability' ? 'selected' : '' }}>EHS & Environment Sustainability</option>
                        <option value="Equipment/Instrument Lifecycle Management" {{ request('process') == 'Equipment/Instrument Lifecycle Management' ? 'selected' : '' }}>Equipment/Instrument Lifecycle Management</option>
                        <option value="ERRATA" {{ request('process') == 'ERRATA' ? 'selected' : '' }}>ERRATA</option>
                        <option value="External Audit" {{ request('process') == 'External Audit' ? 'selected' : '' }}>External Audit</option>
                        <option value="Global CAPA" {{ request('process') == 'Global CAPA' ? 'selected' : '' }}>Global CAPA</option>
                        <option value="Global Change Control" {{ request('process') == 'Global Change Control' ? 'selected' : '' }}>Global Change Control</option>
                        <option value="Incident" {{ request('process') == 'Incident' ? 'selected' : '' }}>Incident</option>
                        <option value="Internal Audit" {{ request('process') == 'Internal Audit' ? 'selected' : '' }}>Internal Audit</option>
                        <option value="Lab Incident" {{ request('process') == 'Lab Incident' ? 'selected' : '' }}>Lab Incident</option>
                        <option value="Meeting" {{ request('process') == 'Meeting' ? 'selected' : '' }}>Meeting</option>
                        <option value="Preventive Maintenance" {{ request('process') == 'Preventive Maintenance' ? 'selected' : '' }}>Preventive Maintenance</option>
                        <option value="RCA" {{ request('process') == 'RCA' ? 'selected' : '' }}>RCA</option>
                        <option value="Risk Assessment" {{ request('process') == 'Risk Assessment' ? 'selected' : '' }}>Risk Assessment</option>
                        <option value="Sanction" {{ request('process') == 'Sanction' ? 'selected' : '' }}>Sanction</option>
                        <option value="Supllier" {{ request('process') == 'Supllier' ? 'selected' : '' }}>Supplier</option>
                        <option value="Supllier Audit" {{ request('process') == 'Supllier Audit' ? 'selected' : '' }}>Supplier Audit</option>
                    </select>
                    
                </div>
        
                @php 
                $getExternalUsers = DB::table('user_roles')
                    ->where(['q_m_s_roles_id' => '76'])
                    ->select(['user_id', DB::raw('MAX(q_m_s_divisions_id) as q_m_s_divisions_id')])
                    ->groupBy('user_id')
                    ->get();
        
                $userIds = collect($getExternalUsers)->pluck('user_id')->toArray();
        
                $getExternalUser = DB::table('users')
                    ->whereIn('id', $userIds)
                    ->select('id', 'name', 'email')
                    ->get();
                @endphp
        
                <div class="form-group col-md-3">
                    <label for="initiator">Initiator</label>
                    <select id="initiator" name="initiator" class="form-control custom-select">
                        <option value="" disabled selected>Select Initiator</option>
                        @foreach($getExternalUser as $user)
                            <option value="{{ $user->id }}" {{ request('initiator') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
        
                <div class="form-group col-md-3">
                    <label for="startDate">Start Date</label>
                    <input type="date" id="startDate" name="startDate" class="form-control" value="{{ request('startDate') }}">
                </div>
        
                <div class="form-group col-md-3">
                    <label for="endDate">End Date</label>
                    <input type="date" id="endDate" name="endDate" class="form-control" value="{{ request('endDate') }}">
                </div>
            </div>
        
            <div class="text-right d-flex justify-content-end align-items-center">
                <button type="submit" class="btn btn-primary custom-button mr-2">
                    <i class="fas fa-search"></i> Apply Filters
                </button>
                <a href="{{ route('qmsRecordAnalytics') }}" class="btn btn-secondary custom-button">
                    <i class="fas fa-sync-alt"></i> Reset Filters
                </a>
            </div>
        </form>
        
        <table class="table table-bordered custom-table">
            <thead class="table-header">
                <tr>
                    <th>Process</th>
                    <th>Site/Division</th>
                    <th>Unique ID</th>
                    <th>Record No.</th>
                    <th>Short Description</th>
                    <th>No. of days after opening of Record</th>
                </tr>
            </thead>
            <tbody id="recordTableBody">
                @foreach ($records as $record)
                    @php
                        $recordCreationDate = \Carbon\Carbon::parse($record->created_at);
                        $currentDate = \Carbon\Carbon::now();
                        $daysAfterOpening = $recordCreationDate->diffInDays($currentDate) + 1;
                    @endphp
                    <tr class="table-row">
                        <td>
                            @if ($process === 'Action Item')
                                {{ $record->type }}
                            @elseif ($process === 'Due Date Extension')    
                                {{ $record->type }}
                            @elseif ($process === 'ERRATA')    
                                {{ $record->type }}    
                            @elseif ($process === 'Meeting')    
                                {{ $record->type }}        
                            @else
                                {{ $record->form_type }}
                            @endif
                        </td>                        
                        <td>
                            @if($process === 'CAPA')
                                {{ $record->division_code }}
                            @elseif ($process === 'Due Date Extension')    
                                {{ Helpers::getDivisionName($record->site_location_code) }}
                            @else
                                {{ Helpers::getDivisionName($record->division_id) }}
                            @endif
                        </td>
                        <td>{{ Helpers::recordFormat($record->record) }}</td>
                        <td>
                            <a href="javascript:void(0);" onclick="toggleRecordTable({{ $record->id }})" class="record-link">
                                @if ($process === 'Due Date Extension')
                                    {{ Helpers::getDivisionName($record->site_location_code) }}/{{ $record->type }}/{{ $recordCreationDate->format('Y') }}/{{ Helpers::recordFormat($record->record) }}
                                @elseif ($process === 'ERRATA')    
                                    {{ Helpers::getDivisionName($record->division_id) }}/{{ $record->type }}/{{ $recordCreationDate->format('Y') }}/{{ Helpers::recordFormat($record->record) }}
                                @elseif ($process === 'Meeting')    
                                    {{ Helpers::getDivisionName($record->division_id) }}/{{ $record->type }}/{{ $recordCreationDate->format('Y') }}/{{ Helpers::recordFormat($record->record) }}
                                @else
                                    {{ Helpers::getDivisionName($record->division_id) }}/{{ $record->form_type }}/{{ $recordCreationDate->format('Y') }}/{{ Helpers::recordFormat($record->record) }}
                                @endif
                            </a>
                        </td>
                        <td>
                            @if($process === 'Lab Incident')
                                {{ $record->short_desc }}
                            @elseif($process === 'Complaint Managment')
                                {{ $record->description_gi }}
                            @else
                                {{ $record->short_description }}
                            @endif
                        </td>
                        <td>
                            {{ $daysAfterOpening }} days
                        </td>
                    </tr>
                    <tr id="recordTable_{{ $record->id }}" class="sub-table-row" style="display:none;">
                        <td colspan="6">
                            <table class="table table-bordered">
                                <thead>
                                    <tr style="background-color: #bfd0f2; color: #fff;">
                                        <th class="table-header">Record Stages</th>
                                        <th class="table-header">No. of Days</th>
                                        <th class="table-header">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($record->stage_durations as $stageDuration)
                                        <tr class="
                                            @if(trim($stageDuration['stage']) === $record->active_stage) active-stage-row
                                            @elseif(($loop->index + 1) < $record->active_stage_number) completed-stage-row
                                            @else pending-stage-row
                                            @endif">
                                            <td>
                                                {{ $stageDuration['stage'] }}
                                                @if(trim($stageDuration['stage']) === $record->active_stage)
                                                    <i class="fa fa-car" style="color: #427CE6; margin-left: 10px; animation: moveCar 1.5s ease-in-out infinite;" aria-hidden="true"></i>
                                                @endif
                                            </td>
                                            <td>
                                                @if(trim($stageDuration['stage']) === 'Opened')
                                                    {{ $daysAfterOpening }} days
                                                @else
                                                    {{ $stageDuration['days'] !== null ? ($stageDuration['days'] + 1) . ' days' : 'Not Yet Performed' }}
                                                @endif
                                            </td>
                                            <td class="status-cell">
                                                @if(($loop->index + 1) < $record->active_stage_number)
                                                    <i class="fa fa-check-circle completed-icon" aria-hidden="true"></i> Completed
                                                @elseif(trim($stageDuration['stage']) === $record->active_stage)
                                                    <i class="fa fa-spinner active-icon" aria-hidden="true"></i> In Progress
                                                @else
                                                    <i class="fa fa-clock pending-icon" aria-hidden="true"></i> Pending
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2" style="text-align: right; font-weight: bold;">Maximum Days Spent in Opened Stage:</td>
                                        <td style="text-align: center; font-weight: bold;">
                                            @php
                                                $maxDays = collect($record->stage_durations)
                                                    ->map(function ($stage) use ($record, $daysAfterOpening) {
                                                        return trim($stage['stage']) === 'Opened' ? $daysAfterOpening : ($stage['days'] + 1) ?? 0;
                                                    })
                                                    ->max();
                                            @endphp
                                            {{ $maxDays ?? 'N/A' }} days
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </td>
                    </tr>
                @endforeach
                <tfoot>
                    <tr>
                        <td colspan="5" style="text-align: right; font-weight: bold;">Average Time for Closure:</td>
                        <td style="text-align: center; font-weight: bold;">
                            @php
                            $recordsCollection = collect($records);
                        
                            $totalDays = $recordsCollection->reduce(function ($carry, $record) {
                        
                                $daysForRecord = isset($record->stage_durations)
                                    ? collect($record->stage_durations)->sum('days') + ($record->created_at ? \Carbon\Carbon::parse($record->created_at)->diffInDays(\Carbon\Carbon::now()) + 1 : 0)
                                    : 0;
                        
                                return $carry + $daysForRecord;
                        
                            }, 0);
                            $count = $recordsCollection->filter(function ($record) {
                                return isset($record->stage_durations);
                            })->count();
                        
                            $averageTime = $count > 0 ? round($totalDays / $count, 2) : 'N/A';
                        @endphp
                        
                            {{ $averageTime }} days
                        </td>
                    </tr>
                </tfoot>
                
            </tbody>
        </table>
        
        <style>
            .custom-table {
                width: 100%;
                border-collapse: collapse;
                margin: 20px 0;
                font-size: 1rem;
                background-color: #ffffff;
            }
        
            .table-header th {
                background-color: #bfd0f2;
                color: #000000;
                text-align: center;
                padding: 10px;
            }
        
            .table-row td {
                text-align: center; 
                padding: 10px;
                vertical-align: middle;
            }
        
            .sub-table-row {
                background-color: #f9f9f9;
            }
        
            .active-stage-row {
                background-color: #f0f8ff;
                font-weight: bold;
            }
        
            .record-link {
                color: #bfd0f2;
                text-decoration: none;
                font-weight: bold;
            }
        
            .record-link:hover {
                text-decoration: underline;
            }
        
            .custom-table td,
            .custom-table th {
                border: 1px solid #ddd;
            }
        
            .custom-table tbody tr:hover {
                background-color: #f5f5f5;
            }
        </style>
        <script>
            function toggleRecordTable(recordId) {
               
                var table = document.getElementById("recordTable_" + recordId);
                if (table.style.display === "none") {
                    table.style.display = "table-row";
                } else {
                    table.style.display = "none";
                }
            }
        </script>
        
    </div>
</body>
</html>

@endsection
