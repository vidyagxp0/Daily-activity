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

    <div id="rcms-dashboard">
        <div class="container-fluid">
            <div class="dash-grid">
                <div>
                    <div class="inner-block scope-table" style="height: calc(100vh - 170px); padding: 0;">
                        <div class="grid-block">
                            <div class="group-input">
                                <label for="scope">Type</label>
                                <select id="mailFilter" class="form-select" onchange="filterMails()">
                                    <option value="all">All Mails</option>
                                    <option value="sent">Sent Mails</option>
                                    <option value="received" selected>Received Mails</option>
                                </select>
                            </div>
                        </div>

                        <!-- <div class="main-scope-table table-container">
                            @foreach($combinedMails as $mail)
                                <div class="container-fluid mail-row" data-type="{{ strtolower($mail->type) }}">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="grid-body">
                                                <p>
                                                    @if($mail->type == "Sent")
                                                        <a href="{{ route('notification.details', $mail->id) }}">
                                                            {{ $mail->person }}
                                                        </a>
                                                    @else
                                                        <a href="{{ route('notifications.seen', $mail->id) }}">
                                                            {{ $mail->person }}
                                                        </a>
                                                    @endif
                                                </p>
                                                <p>{{ $mail->short_description }}</p>
                                                <p class="text-center">{{ $mail->type }}</p>
                                                <p>{{ Helpers::getdateFormat1($mail->created_at) }}</p>
                                                <p>
                                                    <span class="notification-dot {{ $mail->notification_status == 0 ? 'green' : 'red' }}"></span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div> -->

                        <div class="main-scope-table table-container">
                            <table class="table table-bordered" id="auditTable">
                                <thead class="table-header11">
                                    <tr>
                                        <th style="width: 6%;">Sr No.</th>
                                        <th style="width: 6%;">Record ID</th>
                                        <th style="width: 10%;">Initiator</th>
                                        <th style="width: 10%;">Process</th>
                                        <th class="td_desc">Short Description</th>
                                        <th style="width: 7%;">Notification Status</th>
                                        <th style="width: 10%;">Notification Received Date</th>
                                        <th style="width: 6%;">Due Date Status</th>
                                        <th style="width: 10%;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $counter = 0; @endphp
                                    @if(!empty($combinedMails))
                                        @foreach($combinedMails as $mail)
                                        @php $counter++; @endphp
                                            <tr style="border: 1px solid black;" class="mail-row" data-type="{{ strtolower($mail->type) }}">
                                                <td class="serial-number" data-index="{{ $counter }}">{{ $counter }}</td>
                                                <td> {{ str_pad($mail->record, 4, '0', STR_PAD_LEFT) }}</td>
                                                <td> {{ Helpers::getInitiatorName($mail->initiator_id) }} </td>
                                                <td> {{ $mail->process_name }} </td>
                                                <td> {{ $mail->short_description }} </td>
                                                <td @if($mail->notification_status == 1) style="background: green;" @else style="background: orange;" @endif>
                                                    @if($mail->notification_status == 1)
                                                        <span class="text-center">Read</span>
                                                    @else
                                                        <span class="text-center">Unread</span>
                                                    @endif
                                                </td>
                                                <td> {{ Helpers::getdateFormat1($mail->created_at) }} </td>
                                                <td>
                                                    @php
                                                        $parsedDueDate = null;
                                                
                                                        if (!empty($mail->due_date)) {
                                                            try {
                                                                // Assuming Helpers::getdateFormat() returns a Carbon date object
                                                                $parsedDueDate = \Carbon\Carbon::parse($mail->due_date); 
                                                            } catch (Exception $e) {
                                                                $parsedDueDate = null;
                                                            }
                                                        }
                                                    @endphp
                                                
                                                    @if($parsedDueDate === null)
                                                        <span>-</span> {{-- Display a placeholder when there is no valid due date --}}
                                                    @else
                                                        @php
                                                            $daysLeft = \Carbon\Carbon::now()->diffInDays($parsedDueDate, false); // Get the number of days difference
                                                        @endphp
                                                
                                                        {{-- Determine the color based on the remaining days --}}
                                                        @if($daysLeft > 7)
                                                            <span style="height: 12px; width: 12px; background-color: green; border-radius: 50%; display: inline-block;"></span>
                                                        @elseif($daysLeft <= 7 && $daysLeft > 1)
                                                            <span style="height: 12px; width: 12px; background-color: orange; border-radius: 50%; display: inline-block;"></span>
                                                        @else
                                                            <span style="height: 12px; width: 12px; background-color: red; border-radius: 50%; display: inline-block;"></span>
                                                        @endif
                                                    @endif
                                                </td>
                                                
                                                <td>
                                                    @if($mail->type == "Sent")
                                                        <div  class="create">
                                                            <a href="{{ route('notification.details', $mail->id) }}"> <button class="button_theme1">Open Notification</button> </a>
                                                        </div>
                                                    @else
                                                        <div  class="create">
                                                            <a href="{{ route('notifications.seen', $mail->id) }}"> <button class="button_theme1">Open Notification</button> </a>
                                                        </div>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            filterMails();
        });

        function filterMails() {
            var filter = document.getElementById('mailFilter').value;
            var rows = document.querySelectorAll('.mail-row');

            var counter = 1;

            rows.forEach(function(row) {
                var mailType = row.getAttribute('data-type');
                
                if (filter === 'all' || filter === mailType) {
                    row.style.display = '';
                    row.querySelector('.serial-number').innerText = counter++;
                } else {
                    row.style.display = 'none';
                }
            });
        }

        document.getElementById('mailFilter').addEventListener('change', function() {
            filterMails();
        });
    </script>

@endsection