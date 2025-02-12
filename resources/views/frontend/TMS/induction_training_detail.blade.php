 {{-- @section('container')

@php
    $ids = is_string($id) ? explode(',', $id) : [];
@endphp

<h2 id="readingTimeContainer">Reading Time: <span id="readingTimeDisplay">00:00:00</span></h2>

<div id="cameraContainer" style="position: fixed; top: 20px; right: 20px; width: 150px; height: 150px; border-radius: 50%; border: 3px solid #ddd; overflow: hidden; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);">
    <video id="cameraFeed" autoplay playsinline style="width: 100%; height: 100%; object-fit: cover;"></video>
</div>

<!-- SOP Content -->
<div id="sopContainer" style="display: none;">
    @foreach ($ids as $singleId)
        <iframe id="theFrame{{ $singleId }}" width="100%" height="800"
            src="{{ url('documents/viewpdf/' . trim($singleId)) }}#toolbar=0"></iframe>
    @endforeach
</div>

<div id="loader" style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 24px; color: #333; display: block;">
    Loading SOP...
</div>

<div id="violationMessage" style="display: none; position: fixed; top: 40%; left: 50%; transform: translate(-50%, -50%); font-size: 18px; color: red; font-weight: bold; background: #fff; padding: 20px; border: 2px solid red; border-radius: 10px; z-index: 999;">
    <p>Violation Detected: Please do not capture photos or videos of the SOP!</p>
</div>

<style>
    body {
        background-color: #f9f9f9;
        color: #333;
        font-family: Arial, sans-serif;
    }

    iframe {
        border: none;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        margin-top: 20px;
    }

    /* Camera Feed Styling */
    #cameraFeed {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs"></script>
<script src="https://cdn.jsdelivr.net/npm/@tensorflow-models/coco-ssd"></script>

<script>
    let video = document.getElementById('cameraFeed');
    let sopContainer = document.getElementById('sopContainer');
    let loader = document.getElementById('loader');
    let violationMessage = document.getElementById('violationMessage');
    let humanDetected = false;
    let detectionInterval;
    let timeoutRedirect;

    // Load the coco-ssd model
    cocoSsd.load().then(model => {
        console.log('Model loaded!');

        // Access the user's camera
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(stream => {
                video.srcObject = stream;

                // Analyze the video feed
                detectionInterval = setInterval(async () => {
                    const predictions = await model.detect(video);

                    // Check for humans
                    humanDetected = predictions.some(prediction =>
                        prediction.class === 'person' && prediction.score > 0.6
                    );

                    // Check for violations
                    const violationDetected = predictions.some(prediction =>
                        (prediction.class === 'cell phone' || prediction.class === 'camera') && prediction.score > 0.6
                    );

                    console.log("Human Detected:", humanDetected, "Violation Detected:", violationDetected);

                    if (violationDetected) {
                        // Show violation message
                        violationMessage.style.display = "block";
                        sopContainer.style.display = "none";
                        loader.style.display = "block";

                        // Optional: Redirect after delay
                        setTimeout(() => {
                            redirectToPreviousRoute();
                        }, 5000);
                    } else if (humanDetected) {
                        // Show the SOP when a human is detected
                        sopContainer.style.display = "block";
                        loader.style.display = "none";
                        violationMessage.style.display = "none";
                    } else {
                        // Hide the SOP and show the loader when no human is detected
                        sopContainer.style.display = "none";
                        loader.style.display = "block";
                        redirectToPreviousRoute();
                    }
                }, 1000);
            })
            .catch(error => {
                console.error("Error accessing the camera:", error);
                alert("Camera access is required to view the SOP.");
                redirectToPreviousRoute();
            });
    });

    function redirectToPreviousRoute() {
        clearIntervals(); // Stop all counters
        alert("No human detected or violation occurred. Redirecting...");
        window.location.href = '{{ url()->previous() }}';
    }

    function clearIntervals() {
        clearInterval(detectionInterval);
        clearTimeout(timeoutRedirect);
    }
</script> --}}

@section('container')

@php
    $ids = is_string($id) ? explode(',', $id) : [];
@endphp

<h2 id="readingTimeContainer">Reading Time: <span id="readingTimeDisplay">00:00:00</span></h2>

<div id="cameraContainer" style="position: fixed; top: 20px; right: 20px; width: 150px; height: 150px; border-radius: 50%; border: 3px solid #ddd; overflow: hidden; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);">
    <video id="cameraFeed" autoplay playsinline style="width: 100%; height: 100%; object-fit: cover;"></video>
</div>

<!-- SOP Content -->
<div id="sopContainer" style="display: none;">
    @foreach ($ids as $singleId)
        <iframe id="theFrame{{ $singleId }}" width="100%" height="800"
            src="{{ url('documents/viewpdf/' . trim($singleId)) }}#toolbar=0"></iframe>
    @endforeach
</div>

<div id="loader" style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 24px; color: #333; display: block;">
    Loading SOP...
</div>

<div id="violationMessage" style="display: none; position: fixed; top: 40%; left: 50%; transform: translate(-50%, -50%); font-size: 18px; color: red; font-weight: bold; background: #fff; padding: 20px; border: 2px solid red; border-radius: 10px; z-index: 999;">
    <p>Violation Detected: Please ensure no objects other than humans are visible!</p>
</div>

<style>
    body {
        background-color: #f9f9f9;
        color: #333;
        font-family: Arial, sans-serif;
    }

    iframe {
        border: none;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        margin-top: 20px;
    }

    /* Camera Feed Styling */
    #cameraFeed {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs"></script>
<script src="https://cdn.jsdelivr.net/npm/@tensorflow-models/coco-ssd"></script>

<script>
    let video = document.getElementById('cameraFeed');
    let sopContainer = document.getElementById('sopContainer');
    let loader = document.getElementById('loader');
    let violationMessage = document.getElementById('violationMessage');
    let detectionInterval;

    // Load the coco-ssd model
    cocoSsd.load().then(model => {
        console.log('Model loaded!');

        // Access the user's camera
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(stream => {
                video.srcObject = stream;

                // Analyze the video feed
                detectionInterval = setInterval(async () => {
                    const predictions = await model.detect(video);

                    // Filter out humans
                    const nonHumanObjects = predictions.filter(prediction => 
                        prediction.class !== 'person' && prediction.score > 0.6
                    );

                    console.log("Objects detected:", predictions);
                    console.log("Non-human objects detected:", nonHumanObjects);

                    if (nonHumanObjects.length > 0) {
                        // If any object other than a human is detected
                        handleViolation(nonHumanObjects);
                    } else if (predictions.some(prediction => prediction.class === 'person' && prediction.score > 0.6)) {
                        // If only humans are detected
                        sopContainer.style.display = "block";
                        loader.style.display = "none";
                        violationMessage.style.display = "none";
                    } else {
                        // If no human is detected
                        console.log("No human detected.");
                        handleViolation([]);
                    }
                }, 1000);
            })
            .catch(error => {
                console.error("Error accessing the camera:", error);
                alert("Camera access is required to view the SOP.");
                redirectToPreviousRoute();
            });
    });

    function handleViolation(nonHumanObjects) {
        clearInterval(detectionInterval); // Stop further detection
        sopContainer.style.display = "none"; // Hide SOP
        violationMessage.style.display = "block"; // Show violation message
        loader.style.display = "block"; // Show loader

        console.log("Violation Details:", nonHumanObjects);

        setTimeout(() => {
            redirectToPreviousRoute(); // Redirect after delay
        }, 5000); // 5 seconds delay
    }

    function redirectToPreviousRoute() {
        alert("Violation detected. Redirecting...");
        window.location.href = '{{ url()->previous() }}';
    }
</script>



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

                            fetch('{{ url('save-induction-reading-time') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    sop_spent_time: counterValue,
                                    id: {{ $job_training_id }},
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
