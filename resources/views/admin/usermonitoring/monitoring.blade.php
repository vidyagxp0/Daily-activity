@php
    $mainmenu = 'User Monitoring';
    $submenu = 'User Monitoring';
@endphp
@extends('admin.layout')

@section('content')

<div class="container">
    {{-- <h3>{{ $mainmenu }}</h3> --}}

    <!-- DataTable for showing user data -->
    <div class="card mb-3">
        <div class="card-header">
            <h4>User Monitoring Table</h4>
        </div>
        <div class="card-body">
            <table id="userTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Serial number</th>
                        <th>Email</th>
                        <th>Login Time</th>
                        <th>Session Time</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $now = now();
                    @endphp
                    @foreach($login_activities as $login_activity)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td> <!-- Serial number -->
                            <td>{{ $login_activity->user ? $login_activity->user->email : 'NO EMAIL' }}</td> <!-- Assuming user_name contains the email -->
                            <td>{{ $login_activity->created_at?->format('d M Y h:i') }}</td> <!-- Session time -->
                            <td>{{ Carbon\Carbon::parse($login_activity->created_at)->diffForHumans($now, true) }}</td> <!-- Session time -->
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Include DataTables.js -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

<script>
    $(document).ready(function() {
        $('#userTable').DataTable({
            "paging": true, // Enable pagination
            "searching": true, // Enable search/filter
            "ordering": true, // Enable sorting
            "info": true, // Show information
            "columnDefs": [{
                "orderable": false, "targets": 0 // Disable sorting on the serial number column
            }]
        });
    });
</script>

@endsection
