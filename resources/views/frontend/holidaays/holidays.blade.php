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

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        <script>
            setTimeout(function () {
                window.location.href = "/rcms/qms-dashboard"; // Redirect to dashboard after 2 seconds
            }, 2000);
        </script>
    @endif

    <!-- Error Message -->
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Company Dropdown -->
    <div class="mb-3">
        <label for="company_id" class="form-label">Select Company</label>
        <select id="company_id" class="form-control" required>
            <option value="">Choose a company</option>
            @foreach($companies as $company)
                <option value="{{ $company->id }}">{{ $company->name }}</option>
            @endforeach
        </select>
    </div>

    <!-- Holiday Fields -->
    <div id="holidayFields">
        <div class="holiday-group mb-3">
            <label>Start Date</label>
            <input type="date" id="start_date_0" class="form-control" required>

            <label>End Date</label>
            <input type="date" id="end_date_0" class="form-control" required>

            <label>Reason</label>
            <input type="text" id="reason_0" class="form-control" required>
        </div>
    </div>

    <!-- Buttons -->
    <button type="button" id="addMore" class="btn btn-secondary">Add More</button>
    <button type="button" id="saveHolidays" class="btn btn-primary">Save Holidays</button>

    <!-- JavaScript -->
    <script>
        // Add more holiday fields dynamically
        let holidayIndex = 1;
        document.getElementById('addMore').addEventListener('click', function () {
            let holidayFields = document.getElementById('holidayFields');

            let newField = `
                <div class="holiday-group mb-3">
                    <label>Start Date</label>
                    <input type="date" id="start_date_${holidayIndex}" class="form-control" required>

                    <label>End Date</label>
                    <input type="date" id="end_date_${holidayIndex}" class="form-control" required>

                    <label>Reason</label>
                    <input type="text" id="reason_${holidayIndex}" class="form-control" required>
                </div>
            `;
            holidayFields.insertAdjacentHTML('beforeend', newField);
            holidayIndex++;
        });

        // Handle save button click
        document.getElementById('saveHolidays').addEventListener('click', function () {
    console.log("Save Holidays button clicked"); // Debugging

    let companyId = document.getElementById('company_id').value;
    let holidays = [];

    // Collect holiday data
    for (let i = 0; i < holidayIndex; i++) {
        let startDate = document.getElementById(`start_date_${i}`)?.value;
        let endDate = document.getElementById(`end_date_${i}`)?.value;
        let reason = document.getElementById(`reason_${i}`)?.value;

        if (startDate && endDate && reason) {
            holidays.push({
                start_date: startDate,
                end_date: endDate,
                reason: reason
            });
        }
    }

    console.log("Collected Data:", { companyId, holidays }); // Debugging

    // Validate company ID and holidays
    if (!companyId || holidays.length === 0) {
        alert("Please select a company and add at least one holiday.");
        return;
    }

    // Prepare the data to send
    let data = {
        company_id: companyId,
        holidays: holidays
    };

    console.log("Data to Send:", data); // Debugging

    // Send the data to the server
    fetch("{{ route('store.holidays') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => {
        console.log("Response Status:", response.status); // Debugging
        if (!response.ok) {
            // Log the response text for more details
            return response.text().then(text => {
                throw new Error(`Network response was not ok. Response: ${text}`);
            });
        }
        return response.json();
    })
    .then(data => {
        console.log('Server Response:', data); // Debugging
        if (data.success) {
            alert("Holidays added successfully!");
            window.location.href = "/rcms/qms-dashboard"; // Redirect after success
        } else {
            alert("Error saving holidays: " + (data.error || "Unknown error"));
        }
    })
    .catch(error => {
        console.error('Error:', error); // Debugging
        alert("An error occurred. Please check the console for details.");
    });
});
    </script>

    <!-- CSRF Token Meta Tag -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

</body>
</html>