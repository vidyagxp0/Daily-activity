<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />

    <title>VidyaGxP - Software</title>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css"
        integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />

    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/nlsiabbt295w89cjmcocv6qjdg3k7ozef0q9meowv2nkwyd3/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <link rel="stylesheet" href="{{ asset('user/css/virtual-select.min.css') }}">
    <script src="{{ asset('user/js/virtual-select.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('user/css/rcms_style.css') }}">
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/stock.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/map.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/continentsLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/usaLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
    <style>
        .bottom-links {
            display: flex;
            align-items: center;
            margin-top: 15px;
            margin-left: 10px;
            
            position: relative;
        }

        .bottom-links div {
            height: 35px;
            margin-right: 15px;
            display: grid;
            place-items: center;
        }

        .bottom-links a {
            color: black;
            width: 100%;
            display: grid;
            place-items: center;
            height: 100%;
            transition: all 0.3s linear;
            text-decoration: none;
        }

        .bottom-links a:hover {
            color: #427CE6;
            text-decoration: none;
        }

        .bottom-links .notification {
            position: absolute;
            right: 0;
            font-size: 1.2rem;
        }
    </style>
</head>

<body>


    {{-- ======================================
            PRELOADER
    ======================================= --}}
    {{-- <div id="preloader">
        <span class="loader"></span>
    </div> --}}


    {{-- ======================================
            HEADER
    ======================================= --}}

    <header>

        {{-- Header Top --}}
        <div class="header_rcms_top">
            <div class="container-fluid">
                <div class="container">
                    <div class="text-center text-light">
                        <strong><span class="bordered-text">{{ config('site.site_name') }}</span></strong>
                    </div>
                </div>
            </div>
        </div>

        <style>
            .bordered-text {
                border: 2px solid #111212;
                padding: 2px 10px;
                border-radius: 20px;
                color: #111212;

                }
        </style>

        <script>
        let timerInterval; // To store the interval ID

        // Function to format time into HH:MM:SS
        function formatTime(duration) {
            const hours = Math.floor(duration / 3600);
            const minutes = Math.floor((duration % 3600) / 60);
            const seconds = Math.floor(duration % 60);
            return `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
        }
        // Function to start the timer in the header
        function startHeaderTimer() {
            const startTime = Math.floor(new Date(localStorage.getItem('currentLoginTime')).getTime() / 1000);

            timerInterval = setInterval(function () {
                const currentTime = Math.floor(Date.now() / 1000);
                const elapsedTime = currentTime - startTime;
                document.getElementById('header-timer').innerText = `Timer: ${formatTime(elapsedTime)}`;  
                //here i haave also store the value in the above variable $time 
            }, 1000);
        }

        // Function to stop the timer
        function stopHeaderTimer() {
            clearInterval(timerInterval);
            document.getElementById('header-timer').innerText = `Timer: 00:00:00`; // Reset the timer
        }

        // Check on page load if the user is already logged in
        window.addEventListener('load', function () {
            const storedLoginTime = localStorage.getItem('currentLoginTime');
            const logData = JSON.parse(localStorage.getItem('logData')) || [];

            if (storedLoginTime) {
                // User is logged in, continue the timer
                startHeaderTimer();

                // Display last login and logout times (if available)
                if (logData.length > 0) {
                    const lastLogin = logData.filter(entry => entry.type === 'login').pop();
                    const lastLogout = logData.filter(entry => entry.type === 'logout').pop();

                    if (lastLogin) {
                        document.getElementById('login-time').innerText = `Login Time: ${new Date(lastLogin.time).toLocaleTimeString()}`;
                    }
                    if (lastLogout) {
                        document.getElementById('logout-time').innerText = `Logout Time: ${new Date(lastLogout.time).toLocaleTimeString()}`;
                    }
                }

                document.getElementById('loginBtn').disabled = true;
                document.getElementById('logoutBtn').disabled = false;
            }
        });
    </script>

        {{-- Header Middle --}}
        <div class="header_rcms_middle">
            <div class="container-fluid">
                <div class="container-fluid">
                    <div class="middle-head">
                        <div class="logo-container">
                            <div class="logo">
                                <img src="{{ asset('user/images/vidhyagxp.png') }}" alt="..."
                                    class="w-100 h-100" style="scale: 1; pointer-events: none;">
                            </div>
                            <div style="    margin-left: -17px;" class="logo">
                                <img src="https://ipc.gov.in/images/new_logo.png" alt="..." class="w-100 h-100" style="scale: 1.3; pointer-events: none;"> 
                           </div>
                            {{-- <div class="logo">
                             <img src="https://www.medicefpharma.com/wp-content/uploads/2020/06/medicef-logo-new1.png" alt="..." class="w-100 h-100">
                            </div> --}}
                        </div>
                        <div class="icon-grid">
                        <div class="header">
                        <span id="header-timer" class="timer-display">Timer: 00:00:00</span>
                    </div>
                            <div class="icon-drop">
                                <div class="icon">
                                <div class="profile-image">
                                @if (Auth::user() && Auth::user()->profile_image)
                                <img src="{{ asset( Auth::user()->profile_image) }}" alt="Profile Image">
                                @else
                                <i class="fa-solid fa-user-tie" style="font-size: 1rem; color: #427CE6;"></i>
                                @endif
                            </div>
                                    <!-- <i class="fa-solid fa-user-tie"></i> -->
                                    @if (Auth::user())
                                        {{ Auth::user()->name }}
                                        {{-- @else
                                        Amit Guru --}}
                                    @endif
                                    <i class="fa-solid fa-angle-down"></i>
                                </div>
                                <!-- <div class="icon-block small-block">
                                    {{-- <div data-bs-toggle="modal" data-bs-target="#setting-modal">Settings</div> --}}
                                    <div data-bs-toggle="modal" data-bs-target="#about-modal">About</div>
                                    {{-- <div><a href="#">Help</a></div> --}}
                                    <div><a href="/rcms/helpdesk-personnel">Helpdesk Personnel</a></div>
                                    <div><a href="{{ url('rcms/logout') }}">Log Out</a></div>
                                </div> -->

                                <div class="icon-block small-block">
                                <div data-bs-toggle="modal" data-bs-target="#about-modal">
                                    <i class="fa-solid fa-info-circle me-2"></i> About
                                </div>
                                <div data-bs-toggle="modal" data-bs-target="#user-modal">
                                    <i class="fa-solid fa-user-edit me-2"></i> Update Profile
                                </div>
                                <div>
                                    <a href="/helpdesk-personnel">
                                        <i class="fa-solid fa-headset me-2"></i> HelpDesk Personnel
                                    </a>
                                </div>
                                <div>
                                    <a href="" id="logoutBtn">
                                        <i class="fa-solid fa-right-from-bracket me-2"></i> Log Out
                                    </a>
                                </div>

                            </div>
                            </div>
                            <a href="{{ route('user-notification') }}" style="font-size: 30px; margin-right: 10px;">
                             <i class="fa-solid fa-bell" style="color: #427CE6;"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <style>
                    .profile-container {
                        display: flex;
                        align-items: center;
                        padding: 10px;
                        background: #f8f9fa;
                        border-radius: 8px;
                        box-shadow: 0 4px 8px rgb(0 0 0 / 36%);
                        transition: all 0.3s ease-in-out;
                        cursor: pointer;
                    }

                    .profile-container:hover {
                        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
                    }

                    .profile-image img {
                        width: 27px;
                        height: 26px;
                        border-radius: 50%;
                        border: 3px solid #427CE6;
                        margin-right: 15px;
                        transition: border-color 0.3s ease-in-out;
                    }

                    .profile-container:hover .profile-image img {
                        border-color: #0056b3;
                    }

                    .profile-info {
                        display: flex;
                        flex-direction: column;
                        justify-content: center;
                    }

                    .profile-name {
                        font-size: 16px;
                        font-weight: 600;
                        color: #333;
                    }

                  
                    .dropdown-icon {
                        position: absolute;
                        right: -20px; 
                        top: 8px; 
                    }

                    @media (max-width: 576px) {
                    .profile-container {
                        flex-direction: row; 
                        justify-content: flex-start;
                    }

                    .profile-image img {
                        width: 50px;
                        height: 50px;
                    }

                    .profile-info {
                        align-items: flex-start;
                    }

                    .dropdown-icon {
                        top: 5px;
                        right: 0px;
                    }
                }

                    .dropdown-icon i {
                        font-size: 14px;
                        color: #427CE6;
                        transition: transform 0.3s ease-in-out;
                    }
                    .profile-container:hover .dropdown-icon {
                    
                    margin-left:10px;
                        transform: rotate(180deg);
                    }
                    @media (max-width: 576px) {
                    .profile-container {
                        flex-direction: column;
                        align-items: center;
                        text-align: center;
                    }

                    .profile-image {
                        margin-right: 0;
                        margin-bottom: 10px;
                    }
                }
                .overflow-header{
                    width: 1500px;
                    margin-bottom: 10px;
                }
                .overflow-head{
                    overflow-x: auto;
                }

                </style>
                   <script>
            const logoutBtn = document.getElementById('logoutBtn');
            const logoutTimeDisplay = document.getElementById('logout-time');

            logoutBtn.addEventListener('click', function (event) {
                event.preventDefault(); // Prevent default link behavior

                const logoutTime = new Date(); // Get the current time
                const loginTime = new Date(localStorage.getItem('currentLoginTime')); // Parse the login time into Date object
                const logoutEntry = { type: 'logout', time: logoutTime }; // Create a logout entry object

                // Retrieve the existing log data
                let logData = JSON.parse(localStorage.getItem('logData')) || [];
                logData.push(logoutEntry); // Add the new logout entry

                localStorage.setItem('logData', JSON.stringify(logData)); // Save updated log data to localStorage

                // Prepare data to send to the backend
                const dataToSend = {
                    logout_time: logoutTime.toString(),
                    login_time: loginTime.toString(),
                    user_id: '{{ auth()->user()->id }}', // Pass the logged-in user ID from Blade
                    user_name: '{{ auth()->user()->name }}', // Pass the logged-in user ID from Blade
                };

                stopHeaderTimer();
                    // Clear localStorage except for the timer
                    const currentLoginTime = localStorage.getItem('currentLoginTime');
                    localStorage.clear();
                    localStorage.setItem('currentLoginTime', currentLoginTime); // Keep only the current session's login time

                    fetch('{{ route("rcms.storeSessionTime") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify(dataToSend),
                    })
                    .then(response => {                    
                        console.log('Status:', response.status); // Check for status code
                        return response.json(); // Parse the response as JSON instead of text
                    })
                    .then(data => {
                        console.log('Response data:', data); // Output response content for debugging
                        if (data.redirect_url) {
                            window.location.href = data.redirect_url; // Redirect using the URL from the response
                        }
                    })
                    .catch(error => {
                        console.error('Error saving logout data:', error);
                    });

            });
        </script>


        {{-- Header Bottom --}}
        <div class="header_rcms_bottom">
            <div class="container-fluid">
                <div class="bottom-head">
                    <div class="left-block">
                        <div class="link-block">
                            <a href="{{ url('rcms/qms-dashboard') }}" data-bs-toggle="tooltip" title="Dekstop">
                                <i class="fa-solid fa-house-user"></i>
                            </a>
                            <button class="btn-transparent bg-transparent text-black" data-bs-toggle="modal" data-bs-target="#log-sop-modal" title="Logs">
                                <i class="fa-solid fa-gauge-high"></i>
                            </button>
                            
                        </div>
                    </div>
                    <div class="right-block">
                        <div class="search-bar">
                            <form>
                                <label for="search"><i class="fa-solid fa-magnifying-glass"></i></label>
                                <input type="text" name="search" id="searchInput" placeholder="Search...">
                            </form>
                        </div>
                        <div class="create">
                            <a href="{{ url('rcms/form-division') }}"> <button class="button_theme1">Create Record</button> </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- <div class="header-bottom">
                <div class="container-fluid">
                    <div class="bottom-links" style="font-size: 74%;">
                        <div>
                            <a href="#"><i class="fa-solid fa-braille"></i></a>
                        </div>
                        <div>
                            <a href="/dashboard">DMS Dashboard</a>
                        </div>
                        <div>
                            <a href="/TMS">TMS Dashboard</a>
                        </div>
                        <div>
                            <a href="/rcms/qms-dashboard">QMS-Dashboard</a>
                        </div>
                        <div>
                                    <a href="/rcms/regulatory_dashboard">Regulatory Inspection</a>
                                    </div> 
                                    <div>
                                        <a href="/rcms/Compliance_dashboard">Compliance Dashboard</a>
                                        </div> 
                                        <div>
                                        <a href="/rcms/gmp_inspection_databases">GMP Inspection Databases</a>
                                        </div> 
                        @if (Auth::user())
                            @if (Helpers::checkRoles(3) || Helpers::checkRoles(1) || Helpers::checkRoles(2))
                                <div>
                                    <a href="/mydms">My DMS</a>
                                </div>
                            @endif
                       
                            @if (Helpers::checkRoles(3))
                                <div>
                                    <a href="{{ route('documents.index') }}">Documents</a>
                                </div>
                            @endif
                            @if (Helpers::checkRoles(1) || Helpers::checkRoles(2) || Helpers::checkRoles(4))
                                <div>
                                    <a href="{{ url('mytaskdata') }}">My Tasks</a>
                                </div>
                            @endif
                            @if (Helpers::checkRoles(1) || Helpers::checkRoles(2) || Helpers::checkRoles(4))
                            <div>
                                <a href="{{ url('myactivity') }}">My Activity</a>
                            </div>
                            @endif
                          
                        @endif

                        <div>
                            <a href="/rcms/login-logout-session">Login Activity</a>
                        </div>
                   
                    <div>
                                <a class="btn-transparent bg-transparent text-black vidhyagxpacademy" data-bs-toggle="modal" data-bs-target="#log-sop-modal-New" title="Logs" >VidyaGxP Academy</a>
                            </div>
                     
                    </div>
                </div>
            </div> --}}
            <div class="header-bottom" style="font-size: 90%; box-shadow: 0 2px 15px rgb(50 75 179 / 75%);">
                <div class="container-fluid overflow-head">
                    <div class="bottom-links  overflow-header" style="font-size: 87%;">
                        <div>
                            <a href="#" class="{{ Request::is('/') ? 'active' : '' }}"><i class="fa-solid fa-braille"></i></a>
                        </div>
                        <div>
                            <a href="/dashboard" class="{{ Request::is('dashboard') ? 'active' : '' }}">Dashboard</a>
                        </div>
                        <div>
                            <a href="/TMS" class="{{ Request::is('TMS') ? 'active' : '' }}">TMS Dashboard</a>
                        </div>
                        <div>
                            <a href="/rcms/qms-dashboard" class="{{ Request::is('rcms/qms-dashboard') ? 'active' : '' }}">QMS-Dashboard</a>
                        </div>
                        <div>
                            <a href="/ksi-overview" class="{{ Request::is('/ksi-overview') ? 'active' : '' }}">KPI-Analytics</a>
                        </div>
                        <div>
                            <a href="/rcms/Compliance_dashboard" class="{{ Request::is('rcms/Compliance_dashboard') ? 'active' : '' }}">Compliance Dashboard</a>
                        </div>
                        @if (Auth::user())
                            @if (Helpers::checkRoles(3) || Helpers::checkRoles(1) || Helpers::checkRoles(2))
                                <div>
                                    <a href="/mydms" class="{{ Request::is('mydms') ? 'active' : '' }}">My DMS</a>
                                </div>
                            @endif
                            @if (Helpers::checkRoles(3))
                                <div>
                                    <a href="{{ route('documents.index') }}" class="{{ Request::is('documents') ? 'active' : '' }}">Documents</a>
                                </div>
                            @endif
                            @if (Helpers::checkRoles(1) || Helpers::checkRoles(2) || Helpers::checkRoles(4))
                                <div>
                                    <a href="{{ url('mytaskdata') }}" class="{{ Request::is('mytaskdata') ? 'active' : '' }}">My Tasks</a>
                                </div>
                            @endif
                            @if (Helpers::checkRoles(1) || Helpers::checkRoles(2) || Helpers::checkRoles(4))
                                <div>
                                    <a href="{{ url('myactivity') }}" class="{{ Request::is('myactivity') ? 'active' : '' }}">My Activity</a>
                                </div>
                            @endif
                            <div>
                                <a href="/rcms/login-logout-session" class="{{ Request::is('rcms/login-logout-session') ? 'active' : '' }}">Login Activity</a>
                            </div>
                            <div>
                                <a class="btn-transparent bg-transparent text-black vidhyagxpacademy" data-bs-toggle="modal" data-bs-target="#log-sop-modal-New" title="Logs">VidyaGxP Academy</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
        </div>
        <style>
            .bottom-links a.active {
        color: #000; 
        font-weight: bold; 
        border-bottom: 2px solid #427CE6; 
        text-decoration: none; 
        }

        .bottom-links a {
            color: black; 
            transition: color 0.3s, border-bottom 0.3s; 
        }

        </style>

    </header>


    {{-- ======================================
                    STANDARDS MODAL MODAL
    ======================================= --}}
    <div class="modal fade" id="standards-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Standards</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="standard-list">
                        <div class="item">ISO 14971</div>
                        <div class="item">ICH Q10</div>
                        <div class="item">ICH Q9</div>
                        <div class="item">ISO 17025</div>
                        <div class="item">ISO 9001</div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <style>
        #standards-modal .standard-list {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        #standards-modal .standard-list .item {
            background: #4274da52;
            padding: 7px 15px;
            border-radius: 5px;
            box-shadow: rgba(0, 0, 0, 0.12) 0px 1px 3px, rgba(0, 0, 0, 0.24) 0px 1px 2px;
            transition: all 0.3s linear;
            cursor: pointer;
        }

        #standards-modal .standard-list .item:hover {
            background: #427CE6;
            color: white
        }
    </style>




    {{-- ======================================
                    SETTING MODAL
    ======================================= --}}
    <div class="modal fade" id="setting-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">User's Settings</h4>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal"> <i class="fa fa-times"></i> </button>
                </div>

                <div class="modal-body">
                    <div class="image">
                        <img src="{{ asset('user/images/login.jpg') }}" alt="..." class="w-100 h-100">
                    </div>
                    <div class="bar">
                        <strong>Name : </strong> Amit Guru
                    </div>
                    <div class="bar">
                        <strong>E-Mail : </strong> amit.guru@vidyaGxP.io
                    </div>
                    <div class="bar">
                        <a href="#">Change Password</a>
                    </div>
                </div>

            </div>
        </div>
    </div>





    {{-- ======================================
                    USER MODAL
    ======================================= --}}
    <div class="modal fade" id="user-modal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            
            <div class="modal-header">
                <h4 class="modal-title" id="userModalLabel">Change Profile</h4>
                <button type="button" class="btn btn-light" data-bs-dismiss="modal"> <i class="fa fa-times"></i> </button>
                </div>

          
            <div class="modal-body">
            @if (session('success'))
                 <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form id="profile-update-form" action="{{ route('update-profile') }}" method="POST" enctype="multipart/form-data">
            @csrf
                    
             
                    <div class="mb-3 text-center">
                    <img src="{{ asset( Auth::user()->profile_image) }}" alt="Profile Image"id="profile-img-preview" class="rounded-circle mb-3" style="width: 100px; height: 100px;">

                        <div>
                            <label for="profile-image" class="btn btn-outline-primary btn-sm">
                                <i class="fa-solid fa-upload"></i> Change Profile Image
                            </label>
                            <input type="file" id="profile-image" name="profile_image" accept="image/*" class="d-none">
                        </div>
                    </div>

                 
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ Auth::user()->name }}" placeholder="Enter your name">
                    </div>

              
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ Auth::user()->email }}" placeholder="Enter your email">
                    </div>

                    <div class="text-center">
                    <button type="submit" class="btn custom-btn">
                        <i class="fa-solid fa-save me-1"></i> Save 
                    </button>


                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<style>
        .modal-header {
    background-color: #427CE6;
    color: #fff;
    
}
    .form-label {
    font-weight: 600;
    color: #333;
}

#profile-img-preview {
    border: 2px solid #427CE6;
    padding: 5px;
}
 
.custom-btn {
    background-color: #427CE6;
    border-color: #427CE6;
    color: #fff; /* Text color */
}

.custom-btn:hover {
    background-color: #365c9a; 
    border-color: #365c9a;
}
</style>


    {{-- ======================================
                    ABOUT MODAL
    ======================================= --}}
    <div class="modal fade" id="about-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">About</h4>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal"> <i class="fa fa-times"></i> </button>
                </div>

                <div class="modal-body">
                    <!-- <h5 class="company-name text-center mb-4">
                    <strong>Indian Pharmacopoeia Commission</strong>
                    </h5> -->
                    <div class="logo">
                        <img src="{{ asset('user/images/vidhyagxp.png') }}" alt="..." class="w-100 h-100">
                    </div>
                    <div class="bar">
                    <strong>Version : </strong> 2.1.1
                    </div>
                    <div class="bar">
                        <strong>Build # : </strong> 2
                    </div>
                    <div class="bar">
                        April 23, 2023
                    </div>
                    <div class="bar">
                        <strong>Licensed to : </strong> VidyaGxP
                    </div>
                    <div class="bar">
                        <strong>Environment : </strong> Master Demo Dev
                    </div>
                    <div class="bar">
                        <strong>Server : </strong> SCRRREVE3 (100.23.34.0)
                    </div>
                    <div class="copyright-bar">
                        <i class="fa-regular fa-copyright"></i>&nbsp;
                        Copyright 2023 VidyaGXP Private Limited
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="log-sop-modal-New" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" style="margin-left: 150px; font-weight: bold;" id="exampleModalLabel">Quick Links  <i style="margin-left: 20px;" class="fa-solid fa-link"></i></h5>
            <button type="button" class="btn btn-light" data-bs-dismiss="modal"> <i class="fa fa-times"></i> </button>
            </div>
            <style>
               
                #log-sop-modal-New > div > div > div.modal-body.new_links > ul > li{
                    margin-bottom: 20px !important;
                    font-weight: bold !important;

                }
                #log-sop-modal-New > div > div > div.modal-body.new_links > ul > li:hover{
                   color: #427CE6;
                }
                #log-sop-modal-New > div > div > div.modal-body.new_links{
                    background: #333333c4;
                    color: #fff;
                }
                #log-sop-modal-New > div > div > div.modal-body.new_links > ul > li > a{
                    color: #fff;
                }
                #log-sop-modal-New > div > div > div.modal-header{
                    background: #333333c4;
                }
            </style>
            <div class="modal-body new_links">
                <ul>
                    <li>
                        <a href="https://ipc.gov.in/" target="_blank">Medicef Home</a>
    
                        </li>
                        <li>
                            <a href="https://www.iponline.ipc.gov.in/jspui/" target="_blank">Indian Pharmacopeia Online</a>
        
                            </li>
                    <li>
                    <a href="https://www.ema.europa.eu/en/human-regulatory-overview/research-development/compliance-research-development/good-manufacturing-practice/eudragmdp-database" target="_blank">EudraGMDP database | European Medicines Agency (EMA)</a>

                    </li>
                    <li>
                    <a href="https://www.ich.org/" target="_blank">ICH Official</a>

                    </li>
                    <li>
                    <a href="https://www.who.int/" target="_blank">World Health Organization (WHO)</a>

                    </li>
                    <li>
                        <a href="https://www.tga.gov.au/" target="_blank">Therapeutic Goods Administration (TGA)</a>
    
                     </li>
                     <li>
                            <a href="https://www.sahpra.org.za/" target="_blank">SAHPRA - South African Health Products Regulatory Authority</a>
                     </li>
                     <li>
                        <a href="https://picscheme.org/en/publications" target="_blank">Pharmaceutical Inspection Co-operation Scheme</a>
                    </li>
                    <li>
                        <a href="https://www.fda.gov/" target="_blank">U.S. Food and Drug Administration</a>
                    </li>
                    <li>
                        <a href="https://www.pmda.go.jp/english/" target="_blank">Pharmaceuticals and Medical Devices Agency</a>
                    </li>
                    <li>
                        <a href="https://antigo.anvisa.gov.br/" target="_blank">Agência Nacional de Vigilância Sanitária </a>
                    </li>
                    <li>
                        <a href="https://www.gov.uk/government/organisations/medicines-and-healthcare-products-regulatory-agency" target="_blank">Medicines and Healthcare products Regulatory Agency - GOV.UK </a>
                    </li>
                    <li>
                        <a href="https://www.gmp-compliance.org/" target="_blank">ECA Academy</a>
                    </li>
                    <li>
                        <a href="https://www.sologic.com/en-us/rca-software/video-tutorials" target="_blank">SOLOGIC </a>
                    </li>
                </ul>
                
            {{-- @foreach ($logs_list_IPC as $log_list)
                    <p> <a href="{{ route('rcms.logs.show', Str::slug($log_list)) }}" target="_blank">{{ $log_list }}</a> </p>
                @endforeach --}}
            <!-- </div>
            <div class="modal-body"> -->
                
                <!-- <p> <a href="/cc-show" target="">Change Control</a> </p>
                  
                <p> <a href="/action-item-show" target="_blank">Action Item</a> </p>

                <p> <a href="/rca-show" target="_blank">RCA</a> </p>

                <p> <a href="/extensions-show" target="_blank">Extension</a> </p>

                <p> <a href="/effectiveness-checks" target="_blank">Effectivness Check</a> </p>

                <p> <a href="/capa-show" target="_blank">CAPA</a> </p> -->

            </div>
            {{-- <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div> --}}
        </div>
        </div>
    </div>
    <style>
        .company-name {
    font-size: 24px;          
    font-weight: 700;        
    color: #427CE6;           
    text-transform: uppercase; 
    letter-spacing: 1px;     
}

.company-name::after {
    content: '';
    display: block;
    width: 50px;              
    height: 3px;              
    background: #427CE6;     
    margin: 8px auto 0;       
    border-radius: 2px;      
}
    .modal-body .logo {
        width: 200px;
        aspect-ratio: 1/0.35;
        margin: 0 0 20px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .modal-body .logo img {
        object-fit: contain;
        object-position: center;
        max-width: 100%;
        height: auto;
    }

    .modal-body .bar {
        margin-bottom: 5px;
    }

    .modal-body .copyright-bar {
        margin-top: 20px;
        background: #427CE6;
        padding: 5px 10px;
        font-size: 0.9rem;
        color: white;
        letter-spacing: 1px;
    }

    .modal-body {
        /* display: flex; */
        flex-direction: column;
        align-items: center;
    }

    .modal-body .bar strong {
        font-weight: bold;
        color: #427CE6;
    }

    .modal-body .bar:nth-child(odd) {
        background-color: #f0f0f0;
    }
</style>
@php
    $logs_list = [
        'CAPA',
        'Change Control',
        'Deviation',
        'Errata',
        'Failure Investigation',
        'Incident',
        'Inernal Audit',
        'Lab Incident',
        'Market Complaint',
        'Non Conformance',
        'OOC',
        'OOT',
        'Risk Management',
            
    ];                
@endphp

    {{-- LOG LIST MODAL START --}}
    <div class="modal fade" id="log-list-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Log Reports</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
                @foreach ($logs_list as $log_list)
                    <p> <a href="{{ route('rcms.logs.show', Str::slug($log_list)) }}" target="_blank">{{ $log_list }}</a> </p>
                @endforeach
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
        </div>
    </div>
    {{-- LOG LIST MODAL END --}}

     {{-- SOP List START --}}
     <div class="modal fade" id="log-sop-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">SOP Reports</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
                {{-- @foreach ($logs_list as $log_list) --}}
                    <p> <a href="/sop-index-show" target="_blank">SOP </a> </p>
                {{-- @endforeach --}}
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
        </div>
    </div>
    {{-- SOP List MODAL END --}}