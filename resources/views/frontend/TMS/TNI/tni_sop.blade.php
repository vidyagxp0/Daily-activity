{{-- @extends('frontend.layout.main') --}}

@section('container')

    @php
        $ids = is_string($id) ? explode(',', $id) : [];
    @endphp

    <h2 id="readingTimeContainer">Reading Time: <span id="readingTimeDisplay">00:00:00</span></h2>

    @foreach ($ids as $singleId)
        <iframe id="theFrame{{ $singleId }}" width="100%" height="800"
            src="{{ url('documents/viewpdf/' . trim($singleId)) }}#toolbar=0"></iframe>
    @endforeach

    <style>
        #readingTimeContainer {
            position: fixed;
            top: 20px;
            left: 20px;
            background-color: white;
            padding: 10px 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            font-family: Arial, sans-serif;
            font-size: 18px;
            color: #333;
        }

        body {
            background-color: #f9f9f9;
            color: #333;
            font-family: Arial, sans-serif;
        }

        iframe {
            border: none;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
    </style>

    <script>
        let counterIntervals = [];
        let dbIntervals = [];
        let documentId = "{{ $id }}";
            let counterValue = "{{ $sop_spent_time }}" > 0 ? "{{ $sop_spent_time }}" : (parseInt(localStorage.getItem('sop_spent_time')) || 0);

                let totalMinimumTime = {{ $totalMinimumTime * 60 }};
                let perScreenRunningTime = {{ $perScreenRunningTime * 60 }};

                window.onload = function() {

                    // Function to update the counter every second
                    counterInterval = setInterval(function() {
                        counterValue++;
                        localStorage.setItem('sop_spent_time', counterValue);

                        // Format the counter value into HH:MM:SS
                        let hours = Math.floor(counterValue / 3600);
                        let minutes = Math.floor((counterValue % 3600) / 60);
                        let seconds = counterValue % 60;

                        // Add leading zeros if necessary
                        hours = hours < 10 ? '0' + hours : hours;
                        minutes = minutes < 10 ? '0' + minutes : minutes;
                        seconds = seconds < 10 ? '0' + seconds : seconds;

                            document.getElementById("readingTimeDisplay").textContent = hours + ':' + minutes +
                                ':' + seconds;
console.log(document.getElementById("readingTimeDisplay").textContent = hours + ':' + minutes +
':' + seconds);

                        if (counterValue < totalMinimumTime) {
                            disableBackButton();
                        }

                        if (counterValue > perScreenRunningTime) {
                            console.log("Per screen running time reached, redirecting.");
                            redirectToPreviousRoute();
                        }

                        if (counterValue % 5 === 0) {

                            fetch('{{ url('save-classroom-reading-time') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    sop_spent_time: counterValue,
                                    id: {{ $tni_training_id }},
                                })
                            });
                        }

                    }, 1000);
                    counterIntervals.push(counterInterval);
                };

                function disableBackButton() {
                    console.log("Total minimum time reached, disabling back button.");
                    history.pushState(null, null, location.href);
                    window.onpopstate = function() {
                        history.pushState(null, null, location.href);
                    };
                }

                function redirectToPreviousRoute() {
                    clearIntervals(); // Stop all counters
                    window.location.href = '{{ url()->previous() }}';
                }

                function clearIntervals() {
                    counterIntervals.forEach(interval => clearInterval(interval));
                    dbIntervals.forEach(interval => clearInterval(interval));
                }



                window.addEventListener("unload", (event) => {
                    localStorage.removeItem("sop_spent_time");
                });
    </script>

    {{-- @endsection --}}
