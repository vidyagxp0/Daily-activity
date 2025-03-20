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
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
        integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  
    <style>
        .bottom-links {
            display: flex;
            align-items: center;
            margin-top: 15px;
            margin-left: 10px;
            position: relative;
        }

        @media (max-width: 768px) {
            .bottom-links {
            display: flex;
            align-items: center;
            margin-top: 15px;
            margin-left: 10px;
            position: relative;
            height: 55px;
            overflow-x: auto;
        }
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
                        <div class="logo-container" style="display: flex; align-items: center; justify-content: start;">
                            <div class="logo" style="">
                                <img src="{{ asset('user/images/vidhyagxp.png') }}" alt="Vidyagxp Logo" 
                                     style="width: 100px; height: auto; pointer-events: none; scale: 1.3">
                            </div>
                            {{-- <div style="    margin-left: -17px;" class="logo">
                                <img src="https://ipc.gov.in/images/new_logo.png" alt="..." class="w-100 h-100" style="scale: 1.3; pointer-events: none;"> 
                           </div> --}}
                            {{-- <div class="logo">
                                <img src="{{ asset('user/images/vidhyagxp.png') }}" alt="Medicef Pharma Logo"
                                     style="width: 100px; height: auto; pointer-events: none; margin-top: 9px;">
                            </div> --}}
                        </div>
                        
                        
                        

                        
                        
                        

                        <div class="icon-grid">
                        <div class="header">
                        <span id="header-timer" class="timer-display">Timer: 00:00:00</span>
                    </div>
                             <!-- <a href="{{ route('user-notification') }}" style="font-size: 30px; margin-right: 10px;">
                                <i class="fa-solid fa-bell"></i>
                            </a> -->
                            <div class="icon-drop">
                            <div class="icon">
                            <div class="profile-image">
                                @if (Auth::user() && Auth::user()->profile_image)
                                    <img src="{{ asset(Auth::user()->profile_image) }}" alt="Profile Image">
                                @else
                                   <i class="fa-solid fa-user-tie" style="font-size: 1rem; color: #427CE6;"></i>
                                @endif
                            </div>
                            <div>
                                @if (Auth::user())
                                {{ Auth::user()->name }}
                                {{-- @else
                                Amit Guru --}}
                                @endif
                                 <i class="fa-solid fa-angle-down"></i>
                            </div>

                            
                                    
                                   
                                </div>
                                <!-- <div class="icon-block small-block">
                                    {{-- <div data-bs-toggle="modal" data-bs-target="#setting-modal">Settings</div> --}}
                                    <div data-bs-toggle="modal" data-bs-target="#about-modal">About</div>
                                    {{-- <div><a href="#">Help</a></div> --}}
                                    <div><a href="/rcms/helpdesk-personnel">Helpdesk Personnel</a></div>
                                    <div><a href=""  id="logoutBtn">Log Out</a></div>
                                </div> -->
                                <div class="icon-block small-block">
                                <div data-bs-toggle="modal" data-bs-target="#about-modal">
                                    <i class="fa-solid fa-info-circle me-2"></i> About
                                </div>
                                <!-- <div data-bs-toggle="modal" data-bs-target="#user-modal">
                                    <i class="fa-solid fa-user-edit me-2"></i> Update Profile
                                </div> -->
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
                        border-color: #427CE6;
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
                

               try {
                   const currentLoginTime = localStorage.getItem('currentLoginTime');
                    localStorage.clear();
                    localStorage.setItem('currentLoginTime', currentLoginTime); // Keep only the current session's login time
                    let fetchUrl = '{{ route("rcms.storeSessionTime") }}';

                    // Replace 'http' with 'https' if running on an HTTPS server
                    fetchUrl = fetchUrl.replace(/^http:\/\//i, 'https://');
                    
                    fetch(fetchUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify(dataToSend),
                    })
                    .then(response => {
                        console.log('Status:', response.status);
                        return response.json();
                    })
                    .then(data => {
                        console.log('Response data:', data);
                        if (data.redirect_url) {
                            window.location.href = data.redirect_url;
                        }
                    })
                    .catch(error => {
                        console.error('Error occurred:', error);
                    });
               } catch (err) {
                    //   
               }

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
                            <a href="{{ url('rcms/form-division') }}"> <button class="button_theme1">Create
                                    Record</button> </a>
                        </div>
                       
                    </div>
                </div>
            </div>

            <div class="modal fade" id="weekendModal" tabindex="-1" aria-labelledby="weekendModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="weekendModalLabel">Add Weekend Days</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <!-- Form to Save Company and Weekend Days -->
                        <form action="{{ route('weekend.days') }}" method="POST">
                            @csrf

                            <!-- Company Name -->
                            <!-- <label>Company Name:</label>
                            <input type="text" name="company_name" class="form-control" required> -->

                            <label>Weekend Days:</label>
                            <select id="company_name" name="company_name" class="form-control" required>
                                <option value="1">Medicef-Main</option>
                                <option value="2">Annuh-Pharma</option>
                                <option value="3">Environmentlab</option>
                                <option value="4">Invoice-Management</option>
                                <option value="5">Lims-laravel</option>
                            <option value="6">Agio_pre_prod</option>
                            </select>

                            <!-- Weekend Days (Multi-Select) -->
                            <label>Weekend Days:</label>
                            <select id="weekend_days" name="weekend_days[]" class="form-control" multiple required>
                                <option value="Monday">Monday</option>
                                <option value="Tuesday">Tuesday</option>
                                <option value="Wednesday">Wednesday</option>
                                <option value="Thursday">Thursday</option>
                                <option value="Friday">Friday</option>
                                <option value="Saturday">Saturday</option>
                                <option value="Sunday">Sunday</option>
                            </select>

                            <label>Year:</label>
                            <select id="year" name="year" class="form-control" required>
                                <option value="">Select Year</option>
                                <option value="2025">2025</option>
                                <option value="2026">2026</option>
                                <option value="2027">2027</option>
                                <option value="2028">2028</option>
                                <option value="2029">2029</option>
                                <option value="2030">2030</option>
                                <option value="2031">2031</option>
                                <option value="2032">2032</option>
                                <option value="2033">2033</option>
                                <option value="2034">2034</option>
                                <option value="2035">2035</option>
                            </select>

                            <div class="modal-footer mt-3">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        <!-- Include Bootstrap CSS & JS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            VirtualSelect.init({
                            ele: '#weekend_days'
                        });
        </script>

            {{-- <div class="header-bottom">
                <div class="container-fluid">
                    <div class="bottom-links" style="font-size: 87%; overflow-x: auto;">
                        <div>
                            <a href="#"><i class="fa-solid fa-braille"></i></a>
                        </div>
                        <div>
                            <a href="/dashboard">Dashboard</a>
                        </div>
                        <div>
                            <a href="/TMS">TMS Dashboard</a>
                        </div>
                        <div>
                            <a href="/rcms/qms-dashboard">QMS-Dashboard</a>
                        </div>
                        <div>
                             <a href="/rcms/Compliance_dashboard">Compliance Dashboard</a>
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
                            <div>
                            <a href="/rcms/login-logout-session">Login Activity</a>
                        </div>
                          
                            <div>
                                <a class="btn-transparent bg-transparent text-black vidhyagxpacademy" data-bs-toggle="modal" data-bs-target="#log-sop-modal-New" title="Logs" >VidyaGxP Academy</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div> --}}
            <div class="header-bottom" style="font-size: 90%; box-shadow: 0 5px 5px rgb(50 75 179 / 75%);">
                <div class="container-fluid overflow-head">
                    <div class="bottom-links overflow-header" style="font-size: 87%;">
                        <div>
                            <a href="#" class="{{ Request::is('/') ? 'active' : '' }}"><i class="fa-solid fa-braille"></i></a>
                        </div>
                        {{-- <div>
                            <a href="/dashboard" class="{{ Request::is('dashboard') ? 'active' : '' }}">Dashboard</a>
                        </div>
                        <div>
                            <a href="/TMS" class="{{ Request::is('TMS') ? 'active' : '' }}">TMS-Dashboard</a>
                        </div> --}}
                        <div>
                            <a href="/rcms/qms-dashboard" class="{{ Request::is('rcms/qms-dashboard') ? 'active' : '' }}">QMS-Dashboard</a>
                        </div>
                        {{-- <div>
                            <a href="/rcms/lims-dashboard" class="{{ Request::is('rcms/lims-dashboard') ? 'active' : '' }}">LIMS-Dashboard</a>
                        </div> --}}
                        <div>
                            <a href="/Limsanalyticsdashboard" class="{{ Request::is('Limsanalyticsdashboard') ? 'active' : '' }}">Dashboard</a>
                        </div>
                        {{-- <div>
                            <a href="/rcms/qms-record-analytics" class="{{ Request::is('rcms/qms-record-analytics') ? 'active' : '' }}">QMS-Record Analytics</a>
                        </div>
                        <div>
                            <a href="/ksi-overview" class="{{ Request::is('/ksi-overview') ? 'active' : '' }}">KPI-Analytics</a>
                        </div>
                        <div>
                            <a href="/rcms/Compliance_dashboard" class="{{ Request::is('rcms/Compliance_dashboard') ? 'active' : '' }}">Compliance Dashboard</a>
                        </div> --}}
                        @if (Auth::user())
                            @if (Helpers::checkRoles(3) || Helpers::checkRoles(1) || Helpers::checkRoles(2))
                                {{-- <div>
                                    <a href="/mydms" class="{{ Request::is('mydms') ? 'active' : '' }}">My DMS</a>
                                </div> --}}
                            @endif
                            @if (Helpers::checkRoles(3))
                                {{-- <div>
                                    <a href="{{ route('documents.index') }}" class="{{ Request::is('documents') ? 'active' : '' }}">Documents</a>
                                </div> --}}
                            @endif
                            @if (Helpers::checkRoles(1) || Helpers::checkRoles(2) || Helpers::checkRoles(4))
                                {{-- <div>
                                    <a href="{{ url('mytaskdata') }}" class="{{ Request::is('mytaskdata') ? 'active' : '' }}">My Tasks</a>
                                </div> --}}
                            @endif
                            @if (Helpers::checkRoles(1) || Helpers::checkRoles(2) || Helpers::checkRoles(4))
                                {{-- <div>
                                    <a href="{{ url('myactivity') }}" class="{{ Request::is('myactivity') ? 'active' : '' }}">My Activity</a>
                                </div> --}}
                            @endif
                            {{-- <div>
                                <a href="/rcms/login-logout-session" class="{{ Request::is('rcms/login-logout-session') ? 'active' : '' }}">Login Activity</a>
                            </div> --}}
                            {{-- <div>
                                <a class="btn-transparent bg-transparent text-black vidhyagxpacademy" data-bs-toggle="modal" data-bs-target="#log-sop-modal-New" title="Logs">VidyaGxP Academy</a>
                            </div> --}}
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
                    <!-- <button type="button" class="btn-close" data-bs-dismiss="modal"></button> -->
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal"> <i class="fa fa-times"></i> </button>

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
            background: #427CE6;
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
        .vidhyagxpacademy:hover{
            cursor: pointer;
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
                    <!-- <button type="button" class="btn-close" data-bs-dismiss="modal"></button> -->
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
    background-color: #427CE6; 
    border-color: #427CE6;
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
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal"> 
                        <i class="fa fa-times"></i> 
                    </button>
                </div>
    
                <div class="modal-body">
                    <!-- Flex container for the logos -->
                    <div class="logo-container">
                        <div class="logo">
                            <img src="{{ asset('user/images/vidhyagxp.png') }}" 
                                alt="VidyaGxP Logo" 
                                class="logo-img">
                        </div>
                        {{-- <div class="logo">
                            <img src="https://www.medicefpharma.com/wp-content/uploads/2020/06/medicef-logo-new1.png" 
                                alt="Medicef Pharma Logo" 
                                class="logo-img">
                        </div> --}}
                    </div>
    
                    <!-- Other details -->
                    <div class="details">
                        <div class="bar">
                            <strong>Version :</strong> 2.1.1
                        </div>
                        <div class="bar">
                            <strong>Build # :</strong> 2
                        </div>
                        <div class="bar">April 23, 2023</div>
                        <div class="bar">
                            <strong>Licensed to :</strong> Medicef
                        </div>
                        <div class="bar">
                            <strong>Environment :</strong> Master Development
                        </div>
                        <div class="bar">
                            <strong>Server :</strong> SCRRREVE3 (100.23.34.0)
                        </div>
                        <div class="copyright-bar">
                            <i class="fa-regular fa-copyright"></i>&nbsp;
                            Copyright 2023 VidyaGxP Private Limited
                        </div>
                    </div>
                </div>
    
            </div>
        </div>
    </div>
    
    <style>
     
        .modal-header {
            background-color: #427CE6;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    
        .modal-header .modal-title {
            font-size: 1.25rem;
            font-weight: bold;
        }
    
        .modal-header .btn {
            color: #427CE6;
            background: white;
            border: none;
        }
    
        .modal-header .btn:hover {
            background: #f0f0f0;
        }
    
       
        .modal-body .logo-container {
            display: flex;
            justify-content: space-around;
            align-items: center;
            margin-bottom: 20px;
        }
    
      
        .modal-body .logo {
            width: 160px;
            height: auto;
        }
    
        .modal-body .logo img {
            object-fit: contain;
            max-width: 100%;
            max-height: 100%;
        }
    
   
        .modal-body .details {
            text-align: center;
        }
    
        .modal-body .bar {
            margin-bottom: 5px;
        }
    
        .modal-body .bar strong {
            font-weight: bold;
            color: #427CE6;
        }
    
        .modal-body .copyright-bar {
            margin-top: 20px;
            background: #427CE6;
            padding: 5px 10px;
            font-size: 0.9rem;
            color: white;
            letter-spacing: 1px;
        }
    </style>
    
    
@php
    $logs_list_IPC = [
        
         'Change Control',
        // 'Acton Item',
        // 'Audit Program',
        'RCA',
        // 'Due Date Extension',
        // 'Effectivness Check',
        'CAPA',
        'Lab Incident',
        // 'Complaint Management',
        // 'Incident',
        // 'Internal Audit',
        'Deviation',
        'Risk Assessment',
        'OOS',
        // 'Errata',
        'Preventive Maintenance',
        'Equipment/Instrument Lifecycle Management',
        'Calibration Management',
        // 'EHS & Environment Sustainability',
        // 'External Audit',
        // 'Global CAPA ',
        // 'Global Change  Control',
        'New Document',
        // 'Sanction',
        'Supplier',
        'Supplier Audit',
        'Sample Plaining',
        'Sample Stability',
        'Control Sample',
        'Inventory Management',
        'Analyst Qualification'


        

        
    ];                
@endphp

     {{-- SOP List START --}}
     <div class="modal fade" id="log-sop-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">QMS Logs</h5>
            <button type="button" class="btn btn-light" data-bs-dismiss="modal"> <i class="fa fa-times"></i></button>
            </div>
            <div class="modal-body">
                @php
                    // Convert to array if needed and sort alphabetically
                    $sortedLogsList = $logs_list_IPC;
                    sort($sortedLogsList);
                @endphp
            
                @foreach ($sortedLogsList as $log_list)
                    <p class="log-item">
                        <span class="boolean-point {{ $log_list == 'active_log' ? 'active' : 'inactive' }}"></span>
                        <a href="{{ route('rcms.logs.show', Str::slug($log_list)) }}" target="_blank" class="{{ $log_list == 'active_log' ? 'active-link' : '' }}">
                            {{ $log_list }}
                        </a>
                    </p>
                @endforeach
            </div>
            
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
        </div>
    </div>
    <style>
         .modal-body a {
          text-decoration: none;
          color: #000; 
          font-weight: normal;
         }
                
          .modal-body a:hover {
       
         color:#427CE6;
       }
           .btn-light {
            background-color: #f8f9fa;
            color: #333;
            border: none;
            padding: 10px;
        }
    
        /* Modal Body */
        .modal-body {
            padding: 20px;
            background-color: #fff;
        }
    
        .log-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            font-size: 1rem;
        }
    
        .boolean-point {
            width: 10px;
            height: 10px;
            margin-right: 10px;
            border-radius: 50%;
        }
    
        .boolean-point.active {
            background-color: green; 
        }
    
        .boolean-point.inactive {
            background-color: #000; 
        }
    
        .log-item a {
            text-decoration: none;
            color: #000;
            font-weight: normal;
        }
        .active-link {
            color: #427CE6; 
        }
    
    
    </style>
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
                    background: #427CE6;
                    color: #fff;
                }
                #log-sop-modal-New > div > div > div.modal-body.new_links > ul > li > a{
                    color: #fff;
                }
                #log-sop-modal-New > div > div > div.modal-header{
                    background: #427CE6;
                }
            </style>
            <div class="modal-body new_links">
                <ul>
                    <li>
                        <a href="https://ipc.gov.in/" target="_blank">IPC Home</a>
    
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
            </div>
      
        </div>
        </div>
    </div>
  