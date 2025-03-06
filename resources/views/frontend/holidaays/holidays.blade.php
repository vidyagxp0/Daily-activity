<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Company Holidays</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-4">

    <h2 class="mb-4">Add Company Holidays</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form action="" method="POST" id="holidayForm">
        @csrf
        <div class="mb-3">
            <label for="company_id" class="form-label">Select Company</label>
            <select name="company_id" id="company_id" class="form-control" required>
                <option value="">Choose a company</option>
                <option value="1">Medicef</option>
                <option value="2">Annu Pharma</option>
                <option value="3">Vidhyagxp</option>
                <option value="4">IPC</option>
                <option value="5">Agio</option>
                <option value="6">Lims</option>
            </select>
        </div>
    
        <div id="holidayFields">
            <div class="holiday-group mb-3">
                <label>Start Date</label>
                <input type="date" name="holidays[0][start_date]" class="form-control" required>
    
                <label>End Date</label>
                <input type="date" name="holidays[0][end_date]" class="form-control" required>
    
                <label>Reason</label>
                <input type="text" name="holidays[0][reason]" class="form-control" required>
            </div>
        </div>
    
        <button type="button" id="addMore" class="btn btn-secondary">Add More</button>
        <button type="submit" class="btn btn-primary">Save Holidays</button>
    </form>
    

    <script>
        document.getElementById('addMore').addEventListener('click', function () {
            let holidayFields = document.getElementById('holidayFields');
            let index = holidayFields.getElementsByClassName('holiday-group').length;

            let newField = `
                <div class="holiday-group mb-3">
                    <label>Start Date</label>
                    <input type="date" name="holidays[${index}][start_date]" class="form-control" required>

                    <label>End Date</label>
                    <input type="date" name="holidays[${index}][end_date]" class="form-control" required>

                    <label>Reason</label>
                    <input type="text" name="holidays[${index}][reason]" class="form-control" required>
                </div>
            `;
            holidayFields.insertAdjacentHTML('beforeend', newField);
        });
    </script>

    
    <script>
document.getElementById('company_id').addEventListener('change', function () {
    let companyId = this.value;
    let form = document.getElementById('holidayForm');
    
    if (companyId) {
        form.action = "/companies/" + companyId + "/holidays";  
    } else {
        form.action = ""; 
    }
});

</script>
</body>
</html>
