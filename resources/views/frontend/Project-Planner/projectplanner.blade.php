@extends('frontend.layout.main')

@section('container')
<div class="container">
    <h2>Project Planner</h2>
    <form action="{{ route('task.store') }}" method="POST">
        @csrf
        <input type="hidden" name="task_id" value="1">
        <input type="hidden" name="type" value="Task Management">

        <table class="table" id="taskGrid">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Company Name</th>
                    <th>Milestone</th>
                    <th>Functionality</th>
                    <th>No. of Days</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <!-- <td><input type="text" name="data[0][company_name]" class="form-control"></td> -->
                    <td>
                        <select id="" placeholder="Select..." name="dataprojectplanner[0][company_name]" class="form-control">
                            <option value="">-- Select --</option>
                            <option value="agio_pre_prod">Agio_pre_prod</option>
                            <option value="annuh-pharma">Annuh-Pharma</option>
                            <option value="environmentallab">Environmentlab</option>
                            <option value="invoice-management">Invoice-Management</option>
                            <option value="lims-laravel">Lims-laravel</option>
                            <option value="Medicef-main">Medicef-Main</option>
                        </select>
                   </td>
                    <td><input type="text" name="dataprojectplanner[0][milestone]" class="form-control"></td>
                    <td><input type="text" name="dataprojectplanner[0][functionality]" class="form-control"></td>
                    <td><input type="number" name="dataprojectplanner[0][no_of_days]" class="form-control"></td>
                    <td><input type="date" name="dataprojectplanner[0][start_date]" class="form-control"></td>
                    <td><input type="date" name="dataprojectplanner[0][end_date]" class="form-control"></td>
                    <td><button type="button" class="btn btn-success addRow">+</button></td>
                </tr>
            </tbody>
        </table>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    let rowIdx = 1;

    $(".addRow").click(function () {
        let newRow = `
            <tr>
                <td>${rowIdx + 1}</td>
                <td><input type="text" name="dataprojectplanner[${rowIdx}][company_name]" class="form-control"></td>
                <td><input type="text" name="dataprojectplanner[${rowIdx}][milestone]" class="form-control"></td>
                <td><input type="text" name="dataprojectplanner[${rowIdx}][functionality]" class="form-control"></td>
                <td><input type="number" name="dataprojectplanner[${rowIdx}][no_of_days]" class="form-control"></td>
                <td><input type="date" name="dataprojectplanner[${rowIdx}][start_date]" class="form-control"></td>
                <td><input type="date" name="dataprojectplanner[${rowIdx}][end_date]" class="form-control"></td>
                <td><button type="button" class="btn btn-danger removeRow">-</button></td>
            </tr>`;
        $("#taskGrid tbody").append(newRow);
        rowIdx++;
    });

    $(document).on("click", ".removeRow", function () {
        $(this).closest("tr").remove();
    });
});
</script>
@endsection
