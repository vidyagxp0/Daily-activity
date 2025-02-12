{{-- @extends('frontend.layout.main') --}}

{{-- @section('container')

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
    </style> --}}

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
    <p>Violation Detected: Please ensure no phone cameras are visible!</p>
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
    let violationCount = 0;
    const maxViolations = 3;

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
                    const nonHumanObjects = predictions.filter(prediction => 
                        prediction.class !== 'person' && prediction.score > 0.6
                    );

                    console.log("Objects detected:", predictions);
                    console.log("Non-human objects detected:", nonHumanObjects);

                    // Check if a phone or camera is detected
                    const phoneOrCameraDetected = predictions.some(prediction => 
                        prediction.class === 'cell phone' || prediction.class === 'camera' && prediction.score > 0.6
                    );

                    // Handle violation and SOP visibility based on phone/camera detection
                    if (phoneOrCameraDetected) {
                        handleViolation(nonHumanObjects);
                    } else if (predictions.some(prediction => prediction.class === 'person' && prediction.score > 0.6)) {
                        // Show SOP if person (human) detected and no phone/camera is visible
                        sopContainer.style.display = "block";
                        loader.style.display = "none";
                        violationMessage.style.display = "none";
                    } else {
                        handleViolation([]);
                    }

                    // Optional: Detect screen recording software (you can remove if not needed)
                    detectScreenRecording();
                }, 1000);
            })
            .catch(error => {
                console.error("Error accessing the camera:", error);
                alert("Camera access is required to view the SOP.");
                redirectToPreviousRoute();
            });
    });

    function handleViolation(nonHumanObjects) {
        if (violationCount >= maxViolations) {
            redirectToPreviousRoute();
            return;
        }

        violationCount++;
        sopContainer.style.display = "none";  // Hide SOP
        violationMessage.style.display = "block";  // Show violation message
        loader.style.display = "block";  // Show loader

        setTimeout(() => {
            violationMessage.style.display = "none";  // Hide violation message
            loader.style.display = "none";  // Hide loader
        }, 2000); // Hide after 2 seconds
    }

    function detectScreenRecording() {
        // Attempt to detect screen recording software
        if (typeof MediaRecorder !== 'undefined' && MediaRecorder.isTypeSupported && !navigator.mediaDevices.getDisplayMedia) {
            console.log("Screen recording software detected.");
            handleViolation([]);
        }

        try {
            // Check for screen recording (chrome: screen capture API)
            navigator.mediaDevices.enumerateDevices().then(devices => {
                devices.forEach(device => {
                    if (device.kind === 'videoinput' && device.label.includes('screen')) {
                        console.log("Screen recording detected.");
                        handleViolation([]);
                    }
                });
            });
        } catch (err) {
            console.log("Screen recording detection failed:", err);
        }
    }

    function redirectToPreviousRoute() {
        alert("Violation detected. Redirecting...");
        window.location.href = '{{ url()->previous() }}'; // Redirect to previous page
    }
</script>

    <script>
        let counterIntervals = [];
        let dbIntervals = [];
        let documentId = "{{ $id }}";
            let counterValue = "{{ $sop_spent_time }}" > 0 ? "{{ $sop_spent_time }}" : (parseInt(localStorage.getItem('sop_spent_time')) || 0);

            let totalMinimumTime = {{ (int) $totalMinimumTime * 60 }};
            let perScreenRunningTime = {{ (int) $perScreenRunningTime * 60 }};

            
            
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
                        
                        if (counterValue >= perScreenRunningTime) {
                            console.log("Per screen running time reached, redirecting.");
                            redirectToPreviousRoute();
                        }

                        if (counterValue % 5 === 0) {

                            fetch('{{ url('save-tni-matrix-reading-time') }}', {
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
