@extends('frontend.layout.main')

@section('container')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h2 class="text-center mb-4">Project Planner View</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <form action="{{ route('task.update', $task->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <table class="table table-bordered" id="taskGrid">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Company Name</th>
                            <th>Milestone</th>
                            <th>Functionality</th>
                            <th>No. of Days</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th> Remarks</th>
                            <th> Supporting Document</th>
                            

                               <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tasks as $index => $taskGrid)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $taskGrid['company_name'] ?? 'N/A' }}</td>
                                <td>{{ $taskGrid['milestone'] ?? 'N/A' }}</td>
                                <td>{{ $taskGrid['functionality'] ?? 'N/A' }}</td>
                                <td>{{ $taskGrid['no_of_days'] ?? 'N/A' }}</td>
                                <td>{{ $taskGrid['start_date'] ?? 'N/A' }}</td>
                                <td>{{ $taskGrid['end_date'] ?? 'N/A' }}</td>
                                <td>{{ $taskGrid['remark'] ?? 'N/A' }}</td>
                                <td>
                                    <button type="button" class="btn btn-danger removeRow">Remove</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="text-right mt-3">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
