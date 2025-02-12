@php
    $mainmenu = 'User Management';
    $submenu = 'Login Account';
@endphp
@extends('admin.layout')

@section('container')
    <div class="fluid-container mb-3">
        <!-- New Account button -->
        <a href="{{ route('user_management.create') }}" class="btn btn-primary">
            <i class="fas fa-plus nav-icon"></i>
            New Account
        </a>
        <!-- Export button triggers modal -->
        <button class="btn btn-success" data-toggle="modal" data-target="#exportModal">
            <i class="fas fa-file-export"></i> Export
        </button>
    </div>

    <!-- Export Modal -->
    <div class="modal fade" id="exportModal" tabindex="-1" role="dialog" aria-labelledby="exportModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exportModalLabel">Export User List</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Select the format to export the user list:</p>
                    <div class="d-flex justify-content-around">
                        <!-- Export to Excel -->
                        <button class="btn btn-primary export-option" data-type="excel">
                            <i class="fas fa-file-excel"></i> Excel
                        </button>
                        <!-- Export to PDF -->
                        <button class="btn btn-danger export-option" data-type="pdf">
                            <i class="fas fa-file-pdf"></i> PDF
                        </button>
                        <!-- Export to Word -->
                        <button class="btn btn-info export-option" data-type="word">
                            <i class="fas fa-file-word"></i> Word
                        </button>
                        <!-- Export to CSV -->
                        <button class="btn btn-secondary export-option" data-type="csv">
                            <i class="fas fa-file-csv"></i> CSV
                        </button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Login Accounts</h3>
                </div>

                <div class="card-body">
                    <table id="UserData" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Department</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                @php
                                    $RoleList = DB::table('user_roles')->where(['user_id' => $user->id])->pluck('role_id')->toArray();
                                    $role = '';
                                    $roleName = '';
                                    if($RoleList){
                                        $role = implode(',', $RoleList);
                                        $roleNameList = DB::table('q_m_s_roles')
                                            ->whereIn('id', $RoleList)
                                            ->pluck('name')->toArray();
                                        $roleName = implode(',', $roleNameList);
                                    }
                                @endphp
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->dname }}</td>
                                    <td>
                                        <button class="btn btn-dark view-role" data-role="{{ $roleName }}">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                    <td class="text-{{ $user->is_active ? 'success' : 'danger' }}">
                                        {{ $user->is_active ? 'Active' : 'Inactive' }}
                                    </td>
                                    <td>
                                        <a href="{{ route('user_management.edit', $user->id) }}">
                                            <button class="btn btn-dark">Edit</button>
                                        </a>
                                        <a href="{{ route('account.toggle', $user->id) }}" 
                                           class="btn btn-{{ $user->is_active ? 'danger' : 'primary' }}">
                                            {{ $user->is_active ? 'Disable' : 'Enable' }}
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('jquery')
    <!-- Include necessary DataTables and export libraries -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>

    <script>
      $(document).ready(function() {
        // Initialize the DataTable once
        var table = $('#UserData').DataTable({
            dom: 'Bfrtip',
            buttons: [ // Predefine buttons but hide them initially
                {
                    extend: 'excelHtml5',
                    title: 'User List',
                    exportOptions: {
                    columns: [ 0, 1, 2]
                },
                    className: 'd-none' // Hide button initially
                },
                {
                    extend: 'pdfHtml5',
                    title: 'User List',
                    exportOptions: {
                    columns: [ 0, 1, 2]
                },
                    className: 'd-none' // Hide button initially
                },
                {
                    extend: 'csvHtml5',
                    title: 'User List',
                    exportOptions: {
                    columns: [ 0, 1, 2]
                },
                    className: 'd-none' // Hide button initially
                },
                {
                    extend: 'excelHtml5', // Simulating Word export using Excel
                    title: 'User List',
                    exportOptions: {
                    columns: [ 0, 1, 2]
                },
                    filename: 'User_List_Word_Export',
                    className: 'd-none', // Hide button initially
                    customize: function (xlsx) {
                        var sheet = xlsx.xl.worksheets['sheet1.xml'];
                        $('row c', sheet).attr('s', '25');  // Apply a simple Word-like style
                    }
                }
            ]
        });

        // Trigger export buttons based on the option selected
        $('.export-option').click(function() {
            var exportType = $(this).data('type');
            
            // Trigger the appropriate export button without reinitializing the table
            if (exportType === 'excel') {
                table.buttons(0).trigger(); // Trigger Excel export
            } else if (exportType === 'pdf') {
                table.buttons(1).trigger(); // Trigger PDF export
            } else if (exportType === 'csv') {
                table.buttons(2).trigger(); // Trigger CSV export
            } else if (exportType === 'word') {
                table.buttons(3).trigger(); // Trigger simulated Word export
            }

            // Close the modal
            $('#exportModal').modal('hide');
        });
      });
    </script>
@endsection
