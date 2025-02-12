@extends('frontend.rcms.layout.main_rcms')
@section('rcms_container')
    <style>
        header {
            display: none;
        }
    </style>
    {{-- ======================================
                    DASHBOARD
    ======================================= --}}
    <div id="division-config-modal" style=" background-color: #BFD0F2;">
        <div class="division-container">
            <div class="content-container">
                <form action="{{ route('formDivision') }}" method="post">
                    @csrf
                    <div class="division-tabs">
                        <div class="left-block">
                            <div class="head">
                                Function/Site/Division
                            </div>
                            <div class="tab">
                                @php
                                    $userRoles = DB::table('user_roles')->where('user_id', Auth::user()->id)->get();
                                    $divisionIds = [];
                                    foreach($userRoles as $role) {
                                        $divisionIds[] = $role->q_m_s_divisions_id;
                                    }
                                    $divisions = DB::table('q_m_s_divisions')->where('status', 1)->whereIn('id', $divisionIds)->get();
                                @endphp
                                @foreach ($divisions as $temp)
                                    <div class="division-item" onclick="selectDivision({{ $temp->id }})">
                                        <input type="radio" value="{{ $temp->id }}" id="division_{{ $temp->id }}" name="division_id" onclick="openDivision(event, {{ $temp->id }})" required>
                                        <label for="division_{{ $temp->id }}" class="division-label">{{ $temp->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        
                        <!-- Custom CSS -->
                        <style>
                            input[type="radio"] {
                                display: none; 
                            }
                        
                            .division-item {
                                display: flex;
                                align-items: center;
                                cursor: pointer;
                                padding: 8px 12px;
                                border: 2px solid #ddd;
                                border-radius: 4px;
                                transition: background-color 0.3s, border-color 0.3s;
                                margin: 5px;
                                user-select: none; 
                            }
                        
                            .division-label {
                                font-size: 16px;
                                color: #333;
                                margin-left: 10px;
                            }
                        
                            .division-item:hover {
                                background-color: #f0f0f0;
                            }
                            .division-item.active {
                                background-color: #BFD0F2;
                                color: white !important;
                            }
                        
                            .division-item.active:hover {
                                background-color: #BFD0F2;
                            }
                        </style>
                        
                        <!-- JavaScript to handle the active class and radio selection -->
                        <script>
                            function selectDivision(id) {
                                // Find the radio button associated with the clicked division
                                const radioButton = document.getElementById('division_' + id);
                                if (radioButton) {
                                    radioButton.checked = true; // Select the radio button
                                    openDivision(event, id);    // Trigger your custom function to open the division
                                }
                        
                                // Get all division items
                                const divisionItems = document.querySelectorAll('.division-item');
                        
                                // Remove 'active' class from all division items
                                divisionItems.forEach(function(item) {
                                    item.classList.remove('active');
                                });
                        
                                // Add 'active' class to the clicked division item
                                const clickedItem = document.querySelector('#division_' + id).closest('.division-item');
                                clickedItem.classList.add('active');
                            }
                        </script>
                        
                        
                        <div class="right-block">
                            <div class="head">
                                Process
                            </div>
                            @php
                                $processes = DB::table('q_m_s_processes')->get()->keyBy('id');

                                $userRoles = DB::table('user_roles')
                                    ->where('user_id', Auth::user()->id)
                                    ->get()
                                    ->groupBy('q_m_s_divisions_id');
                            @endphp

                            @foreach ($userRoles as $divisionId => $roles)
                                <div id="{{ $divisionId }}" class="divisioncontent bg-light">
                                    @php
                                        $processIds = $roles->pluck('q_m_s_processes_id')->unique()->toArray();

                                        $uniqueProcesses = $processes->whereIn('id', $processIds);

                                        $uniqueProcessNames = [];
                                        $filteredProcesses = [];

                                        foreach ($uniqueProcesses as $process) {
                                            if (!in_array($process->process_name, $uniqueProcessNames)) {
                                                $uniqueProcessNames[] = $process->process_name;
                                                $filteredProcesses[] = $process;
                                            }
                                        }
                                    @endphp

                                    <ul style="list-style-type: disc; padding-left: 35px;"> 
                                        @foreach ($filteredProcesses as $process)
                                        <li>
                                            <label for="process">
                                                <input type="hidden" name="process_id" value="{{ $process->id }}">
                                                <input type="submit" class="bg-light text-dark"
                                                       style="width: 100%; height: 60%; background-color: #011627; color: #fdfffc; padding: 7px; border: 0px; bgcolor="#011627" border="0" type="submit" for="process"
                                                       value="{{ $process->process_name }}" name="process_name" required>
                                            </label>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection