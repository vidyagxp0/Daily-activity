@php
    $mainmenu = 'Block List IP';
    $submenu = 'Block List IP';
@endphp
@extends('admin.layout')

@section('content')


<div class="container mt-1">
    <div class="card shadow-lg">
       
        <div class="card-body">

            <!-- Display success message if any -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <!-- Form to Add a Blacklist Entry -->
            <form action="{{ route('blacklist.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="ip_address">IP Address:</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="ip_address" id="ip_address" placeholder="Enter IP Address" required>
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-ban"></i> Blacklist IP
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            <!-- List of Blacklisted IP Addresses -->
            <h4 class="mt-4"> Blacklisted IP Addresses:</h4>
            <table class="table table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">IP Address</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
        @foreach($blacklists as $blacklist)
        <tr>
            <td>{{ $blacklist->id }}</td>
            <td>{{ $blacklist->ip_address }}</td>
            <td>
                <form action="{{ route('blacklist.destroy', $blacklist->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Are you sure?');">
                        <i class="fas fa-trash-alt"></i> Remove
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
            </table>
        </div>
    </div>
</div>


















@endsection




