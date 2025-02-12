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
    {{-- <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
    </script> --}}

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/nlsiabbt295w89cjmcocv6qjdg3k7ozef0q9meowv2nkwyd3/tinymce/6/tinymce.min.js">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <link rel="stylesheet" href="{{ asset('user/css/virtual-select.min.css') }}">
    <script src="{{ asset('user/js/virtual-select.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('user/css/style.css') }}">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    {{-- @toastr_css --}}
    <style>
        .tox-statusbar__branding{
            display: none;
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
    </style>
</head>

<body>

    <style>
        #create-record-button {
            display: none;
            margin-left: auto;
        }
    </style>


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
        <div class="container-fluid header-top">
            <div class="container">
                <div class="text-center text-light">
                    <strong><span class="bordered-text">{{ config('site.site_name') }}</span></strong>
                </div>
            </div>
        </div>
        <style>
            .bordered-text {
                border: 2px solid #111212;
                padding: 2px 10px;
                border-radius: 20px;
                color:#111212;
                }
        </style>

        {{-- Header Middle --}}
        <div class="container-fluid header-middle">
            <div>
                <div class="middle-head">
                    <div class="logo-container">
                        <div class="logo">
                            <img src="{{ asset('user/images/vidhyagxp.png') }}" alt="..." class="w-100 h-100"
                                style="scale: 1.2">
                        </div>
                        <div style="    margin-left: -27px;" class="logo">
                            <img src="https://ipc.gov.in/images/new_logo.png" alt="..." class="w-100 h-100" style="scale: 1.3; pointer-events: none;"> 
                       </div>
                        {{-- <div class="logo">
                            <img src="https://www.medicefpharma.com/wp-content/uploads/2020/06/medicef-logo-new1.png" alt="..." class="w-100 h-100" style="scale: 0.9; margin-top: 8px;">
                        </div> --}}
                    </div>
                    <div class="search-bar">
                        <form action="#" class="w-100">
                            <label for="search"><i class="fa-solid fa-magnifying-glass"></i></label>
                            <input id="searchInput" type="text" name="search" placeholder="Search">
                            <div data-bs-toggle="modal" data-bs-target="#advanced-search">Advanced Search</div>
                        </form>
                    </div>
                    
                    <div class="icon-grid">
                    <div class="header">
                        <span id="header-timer" class="timer-display">Timer: 00:00:00</span>
                    </div>
                        <div class="icon-drop">
                            <!-- <div class="icon">
                                <i class="fa-solid fa-user-tie"></i>
                                @if (Auth::user())
                                    {{ Auth::user()->name }}
                                @else
                                    Amit Guru
                                @endif
                                <i class="fa-solid fa-angle-down"></i>
                            </div> -->
                            <!-- Profile Section -->
                            <div class="icon">
                            <div class="profile-image">
                                @if (Auth::user() && Auth::user()->profile_image)
                                    <img src="{{ asset( Auth::user()->profile_image) }}" alt="Profile Image">
                                @else
                              <i class="fa-solid fa-user-tie" style="font-size: 1rem; color: #427CE6;"></i>
                                
                                @endif
                            </div>

                            <div class="profile-info">
                                <span class="profile-name">
                                    @if (Auth::user())
                                        {{ Auth::user()->name }}
                                    @else
                                        Amit Guru
                                    @endif
                                    <i class="fa-solid fa-angle-down"></i>
                                </span>
                              
                            </div>
                        </div>

<!-- Custom CSS Styling -->
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
                        border: 3px solid #4274da;
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
                        color: #4274da;
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
                 /* scrollbar */
        ::-webkit-scrollbar {
            width: 5px;
            height: 5px;
          }
          
          ::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
            -webkit-border-radius: 15px;
            border-radius: 15px;
          }
          
          ::-webkit-scrollbar-thumb {
            -webkit-border-radius: 15px;
            border-radius: 15px;
            background: rgba(255, 255, 255, 0.3);
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.5);
          }
          
          ::-webkit-scrollbar-thumb:window-inactive {
            background: rgba(255, 255, 255, 0.3);
          }
                </style>
 
                         

                            <div class="icon-block small-block">
                                <div data-bs-toggle="modal" data-bs-target="#about-modal">
                                    <i class="fa-solid fa-info-circle me-2"></i> About
                                </div>
                                {{-- <div data-bs-toggle="modal" data-bs-target="#user-modal">
                                    <i class="fa-solid fa-user-edit me-2"></i> Update Profile
                                </div> --}}
                                <div>
                                    <a href="/helpdesk-personnel">
                                        <i class="fa-solid fa-headset me-2"></i> HelpDesk Personnel
                                    </a>
                                </div>
                                <div>
                                    <a href="{{ route('logout') }}">
                                        <i class="fa-solid fa-right-from-bracket me-2"></i> Log Out
                                    </a>
                                </div>

                            </div>
                        </div>
                        <a href="{{ route('user-notification') }}" style="font-size: 30px; margin-right: 10px;">
                                <i style="color:#427CE6"class="fa-solid fa-bell"></i>
                            </a>
                    </div>
                </div>
            </div>
        </div>


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

        {{-- Header Bottom --}}
        <!-- <div class="container-fluid header-bottom">





                   <div  class="create" id="create-record-button">
                        <a href="{{ url('rcms/form-division') }}"> <button class="button_theme1">Create Record</button> </a>
                    </div>
                  
                
           <div class="header-bottom">
            <div class="container-fluid">
                <div class="bottom-links">
                    <div>
                        <a href="#"><i class="fa-solid fa-braille"></i></a>
                    </div>
                    <div>
                        <a href="/dashboard">DMS Dashboard</a>
                    </div>
                    <div>
                        <a href="/TMS">TMS Dashboard</a>
                    </div>
                    <div><a href="/rcms/qms-dashboard">QMS-Dashboard</a></div>
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
                        {{-- @if (Helpers::checkRoles(4) || Helpers::checkRoles(5) || Helpers::checkRoles(3))
                            <div>
                                <a href="{{ route('change-control.index') }}">Change Control</a>
                            </div>
                        @endif --}}
                        <div>
                            <a href="{{ url('vacademy') }}">VidyaGxP Academy</a>
                        </div>
                    @endif

             
                    {{-- <div class="notification">
                        <a href="/notifications"><i class="fa-solid fa-bell"></i></a>
                    </div> 

                 <div id="create-record-button">
                        <a href="{{ url('rcms/form-division') }}"> <button class="button_theme1">Create
                                Record</button> </a>
                    </div>--}}
                    
                </div>
            </div>
        </div> -->



        
                   
               
              
          
 <div class="container-fluid header-bottom"  style="font-size: 90%; box-shadow: 0 2px 15px rgb(50 75 179 / 75%);">
    {{-- <div class="container-fluid">
        <div class="header-content">
            <!-- Navigation Links -->
            <div class="bottom-links" style="font-size: 85%;">
                <div class="link-item">
                    <a href="#"><i class="fa-solid fa-braille"></i></a>
                </div>
                <div class="link-item">
                    <a href="/dashboard">DMS Dashboard</a>
                </div>
                <div class="link-item">
                    <a href="/TMS">TMS Dashboard</a>
                </div>
                <div class="link-item">
                    <a href="/rcms/qms-dashboard">QMS Dashboard</a>
                </div>
                <div class="link-item">
                    <a href="/rcms/regulatory_dashboard">Regulatory Inspection</a>
                </div>
                <div class="link-item">
                    <a href="/rcms/Compliance_dashboard">Compliance Dashboard</a>
                </div>
                @if (Auth::user())
                    @if (Helpers::checkRoles(3) || Helpers::checkRoles(1) || Helpers::checkRoles(2))
                        <div class="link-item">
                            <a href="/mydms">My DMS</a>
                        </div>
                    @endif
                    @if (Helpers::checkRoles(3))
                        <div class="link-item">
                            <a href="{{ route('documents.index') }}">Documents</a>
                        </div>
                    @endif
                    @if (Helpers::checkRoles(1) || Helpers::checkRoles(2) || Helpers::checkRoles(4))
                        <div class="link-item">
                            <a href="{{ url('mytaskdata') }}">My Tasks</a>
                        </div>
                    @endif
                    @if (Helpers::checkRoles(1) || Helpers::checkRoles(2) || Helpers::checkRoles(4))
                        <div class="link-item">
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

            <!-- Create Record Button -->
            <div id="create-record-button">
                <a href="{{ url('rcms/form-division') }}">
                    <button class="button_theme1">Create Record</button>
                </a>
            </div>
        </div>
    </div> --}}

    <div class="header-bottom">
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
                    <a href="/rcms/lims-dashboard" class="{{ Request::is('rcms/lims-dashboard') ? 'active' : '' }}">LIMS-Dashboard</a>
                </div>
                <div>
                    <a href="/Limsanalyticsdashboard" class="{{ Request::is('Limsanalyticsdashboard') ? 'active' : '' }}">LIMS Analytics</a>
                </div>
                <div>
                    <a href="/rcms/qms-record-analytics" class="{{ Request::is('rcms/qms-record-analytics') ? 'active' : '' }}">QMS-Record Analytics</a>
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
    .header-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

</style>
        
    <style>
        .bottom-links a.active {
        color: #bfd0f2; 
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
                   color: #4274da;
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
                    <!-- <img src="{{ Auth::user()->profile_image ? asset('storage/' . Auth::user()->profile_image) : asset('user/images/default-profile.png') }}" alt="Profile Image" id="profile-img-preview" class="rounded-circle mb-3" style="width: 100px; height: 100px;"> -->
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
    background-color: #bfd0f2;
    color: #fff;
    
}

.modal-content {
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
}

.form-label {
    font-weight: 600;
    color: #333;
}

#profile-img-preview {
    border: 2px solid #4274da;
    padding: 5px;
}
 
.custom-btn {
    background-color: #4274da;
    border-color: #4274da;
    color: #fff; /* Text color */
}

.custom-btn:hover {
    background-color: #365c9a; 
    border-color: #365c9a;
}

</style>
<script>
    document.getElementById('profile-image').addEventListener('change', function(event) {
    var reader = new FileReader();
    reader.onload = function() {
        var output = document.getElementById('profile-img-preview');
        output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
});

</script>







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

    <style>
        .company-name {
    font-size: 24px;         
    font-weight: 700;        
    color: #4274da;      
    text-transform: uppercase; 
    letter-spacing: 1px;      
}

.company-name::after {
    content: '';
    display: block;
    width: 50px;            
    height: 3px;          
    background: #4274da;      
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
        background: #4274da;
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
        color: #4274da;
    }

    .modal-body .bar:nth-child(odd) {
        background-color: #f0f0f0;
    }
</style>


    {{-- ======================================
                IMPORT EXPORT MODAL
    ======================================= --}}
    <div class="modal fade" id="import-export-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Import/Export Terms</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                </div>

            </div>
        </div>
    </div>




    {{-- ============================================
                RELATED RECORD MODAL
    ============================================= --}}
    <div class="modal fade" id="related-records-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Related Records</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="block">
                        <label for="record_1">
                            <input type="checkbox" name="record" id="record_1" />
                            <div>EHS - North America/CAPA/2023/0001</div>
                        </label>
                    </div>
                    <div class="block">
                        <label for="record_2">
                            <input type="checkbox" name="record" id="record_2" />
                            <div>EHS - North America/CAPA/2023/0002</div>
                        </label>
                    </div>
                    <div class="block">
                        <label for="record_3">
                            <input type="checkbox" name="record" id="record_3" />
                            <div>EHS - North America/CAPA/2023/0003</div>
                        </label>
                    </div>
                    <div class="block">
                        <label for="record_4">
                            <input type="checkbox" name="record" id="record_4" />
                            <div>EHS - North America/CAPA/2023/0004</div>
                        </label>
                    </div>
                </div>

                <div class="modal-footer justify-content-end">
                    <button class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>

            </div>
        </div>
    </div>

    {{-- ============================================
                FISHBONE INSTRUCTION MODAL
    ============================================= --}}
    <div class="modal fade" id="fishbone-instruction-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Cause and Effect Diagram Instructions</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <ol class="list-group">
                        <li class="list-group-item">
                            <strong>Enter the Problem Statement:</strong>
                            <p>Clearly articulate the problem or effect that the team is addressing. Use a concise and
                                specific statement to guide the analysis. Enter this statement in the box provided at
                                the head of the diagram.</p>
                        </li>

                        <li class="list-group-item">
                            <strong>Brainstorm Major Categories:</strong>
                            <p>Encourage team members to brainstorm and identify major categories related to the
                                problem. Use the generic headings provided (Measurement, Materials, Method, Environment,
                                Manpower, Machine, Mentor) as a starting point. Allow for flexibility in creating
                                additional categories as needed.</p>
                        </li>

                        <li class="list-group-item">
                            <strong>Write Categories of Causes:</strong>
                            <p>For each major category identified, write it as a branch extending from the main arrow.
                                Use lines or "bones" to represent these branches, connecting them to the main arrow.
                                Ensure that each category is clearly labeled.</p>
                        </li>

                        <li class="list-group-item">
                            <strong>Detailed Causes as Sub-branches:</strong>
                            <p>Beneath each major category, encourage the team to further detail specific causes. Create
                                sub-branches extending from the main category branches to represent these detailed
                                causes. Use these sub-branches to break down causes into more specific elements.</p>
                        </li>

                        <li class="list-group-item">
                            <strong>Prioritize and Analyze:</strong>
                            <p>After identifying a comprehensive list of potential causes, work as a team to prioritize
                                them. Discuss the potential impact and likelihood of each cause on the problem. Consider
                                using a prioritization method such as voting or consensus.</p>
                        </li>

                        <li class="list-group-item">
                            <strong>Use Visual Elements:</strong>
                            <p>Enhance the clarity and visual appeal of the diagram by using colors, shapes, or icons to
                                differentiate categories. Ensure that labels and text are legible and clearly written.
                                Use a large enough format to accommodate detailed information.</p>
                        </li>

                        <li class="list-group-item">
                            <strong>Facilitate Open Communication:</strong>
                            <p>Create an environment that fosters open communication and collaboration during the
                                brainstorming process. Encourage team members to share their insights and perspectives
                                on potential causes. Use the diagram as a visual aid to facilitate discussions.</p>
                        </li>

                        <li class="list-group-item">
                            <strong>Review and Refine:</strong>
                            <p>Periodically review and refine the Cause and Effect Diagram as more information becomes
                                available. Update the diagram based on feedback, additional data, or changes in the
                                understanding of the problem.</p>
                        </li>

                        <li class="list-group-item">
                            <strong>Document Action Items:</strong>
                            <p>If applicable, document action items or potential solutions next to identified causes.
                                This helps in planning and implementing corrective actions to address the root causes.
                            </p>
                        </li>

                        <li class="list-group-item">
                            <strong>Follow-up and Continuous Improvement:</strong>
                            <p>Use the Cause and Effect Diagram as a tool for continuous improvement. Monitor the
                                effectiveness of implemented solutions and adjust the diagram as needed. Encourage
                                ongoing collaboration and learning within the team.</p>
                        </li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    {{-- ============================================
                WHY WHY CHART INSTRUCTION MODAL
    ============================================= --}}
    <div class="modal fade" id="why_chart-instruction-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Why-Why Analysis: Understanding its Use and Speciality</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5 class="fw-bold">1. Root Cause Identification:</h5>
                            <p>Why-Why analysis is a systematic method designed to uncover the root causes of a problem
                                or an undesired outcome. It helps in going beyond surface-level symptoms to delve into
                                the fundamental reasons behind an issue.</p>
                        </div>

                        <div class="col-12">
                            <h5 class="fw-bold">2. Sequential Questioning:</h5>
                            <p>The technique involves asking "Why" repeatedly in a sequential manner, typically five
                                times, to drill down into the deeper layers of causation. By iteratively asking why, the
                                analysis moves from the initial problem to its underlying causes.</p>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <h5 class="fw-bold">3. Preventing Recurrence:</h5>
                            <p>Why-Why analysis aims not only to solve the current problem but also to prevent its
                                recurrence by addressing the core issues. It is a proactive approach to quality
                                improvement and risk mitigation.</p>
                        </div>

                        <div class="col-12">
                            <h5 class="fw-bold">4. Systematic Problem-Solving:</h5>
                            <p>The process provides a structured framework for problem-solving, ensuring a methodical
                                and organized approach to addressing issues. It guides teams through a logical sequence,
                                fostering comprehensive understanding.</p>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <h5 class="fw-bold">5. Cross-functional Collaboration:</h5>
                            <p>Why-Why analysis is conducive to collaborative efforts, involving individuals from
                                different departments or disciplines. It encourages diverse perspectives, leading to a
                                more holistic understanding of the problem.</p>
                        </div>

                        <div class="col-12">
                            <h5 class="fw-bold">6. Visual Representation:</h5>
                            <p>Often presented in the form of a Why-Why analysis chart or diagram, the visual
                                representation aids in communicating complex causation relationships. Visualizing the
                                chain of "Whys" enhances clarity and comprehension.</p>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <h5 class="fw-bold">7. Continuous Improvement Tool:</h5>
                            <p>Beyond immediate problem resolution, Why-Why analysis is integral to continuous
                                improvement initiatives. It aligns with the principles of Kaizen, fostering an
                                environment of ongoing enhancement.</p>
                        </div>

                        <div class="col-12">
                            <h5 class="fw-bold">8. Speciality in Complex Problem Solving:</h5>
                            <p>Particularly effective in situations where problems are multifaceted and their origins
                                are not immediately apparent. It excels in addressing complex issues by breaking them
                                down into manageable components.</p>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <h5 class="fw-bold">9. Data-Driven Decision Making:</h5>
                            <p>Why-Why analysis relies on factual information and data to support each "Why" question.
                                It promotes evidence-based decision-making, reducing reliance on assumptions or
                                subjective opinions.</p>
                        </div>

                        <div class="col-12">
                            <h5 class="fw-bold">10. Feedback Loop Establishment:</h5>
                            <p>The process establishes a feedback loop by evaluating the effectiveness of implemented
                                solutions. This iterative nature ensures that adjustments can be made, and improvements
                                sustained over time.</p>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

    {{-- ============================================
                IS/IS NOT INSTRUCTION MODAL
    ============================================= --}}
    <div class="modal fade" id="is_is_not-instruction-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Is/Is Not Analysis</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <h5 class="fw-bold">Uses:</h5>
                            <ul>
                                <li><strong>IS (Is):</strong> Helps define what a concept or system "is."</li>
                                <li><strong>Is Not (Is Not):</strong> Clearly outlines what the concept or system is
                                    not, eliminating ambiguity.</li>
                            </ul>
                        </div>

                        <div class="col-12">
                            <h5 class="fw-bold">Clarity in Definition:</h5>
                            <ul>
                                <li><strong>IS (Is):</strong> Identifies the essential features and characteristics of a
                                    system or product.</li>
                                <li><strong>Is Not (Is Not):</strong> Excludes non-essential elements, preventing scope
                                    creep in project requirements.</li>
                            </ul>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <h5 class="fw-bold">Problem-Solving:</h5>
                            <ul>
                                <li><strong>IS (Is):</strong> Facilitates a systematic approach to problem-solving by
                                    focusing on the core aspects of an issue.</li>
                                <li><strong>Is Not (Is Not):</strong> Helps avoid distractions and irrelevant factors
                                    that may hinder problem resolution.</li>
                            </ul>
                        </div>

                        <div class="col-12">
                            <h5 class="fw-bold">Communication Aid:</h5>
                            <ul>
                                <li><strong>IS (Is):</strong> Enhances communication by providing a concise and precise
                                    description of a subject.</li>
                                <li><strong>Is Not (Is Not):</strong> Reduces misunderstandings by clearly stating what
                                    a concept or system does not involve.</li>
                            </ul>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <h5 class="fw-bold">Decision Making:</h5>
                            <ul>
                                <li><strong>IS (Is):</strong> Assists decision-making by highlighting the key attributes
                                    and components.</li>
                                <li><strong>Is Not (Is Not):</strong> Eliminates confusion by ruling out aspects that
                                    should not be considered in the decision-making process.</li>
                            </ul>
                        </div>

                        <div class="col-12">
                            <h5 class="fw-bold">Specialty:</h5>
                            <ul>
                                <li><strong>Precision in Definition:</strong></li>
                                <ul>
                                    <li><strong>IS (Is):</strong> Enables a detailed and accurate definition of a
                                        subject.</li>
                                    <li><strong>Is Not (Is Not):</strong> Adds specificity by negating misconceptions
                                        and peripheral elements.</li>
                                </ul>
                            </ul>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <h5 class="fw-bold">Scope Delimitation:</h5>
                            <ul>
                                <li><strong>IS (Is):</strong> Clearly defines the boundaries and scope of a concept or
                                    system.</li>
                                <li><strong>Is Not (Is Not):</strong> Sets limitations, preventing the inclusion of
                                    irrelevant or extraneous details.</li>
                            </ul>
                        </div>

                        <div class="col-12">
                            <h5 class="fw-bold">Risk Mitigation:</h5>
                            <ul>
                                <li><strong>IS (Is):</strong> Identifies potential risks associated with a system or
                                    project.</li>
                                <li><strong>Is Not (Is Not):</strong> Helps in risk management by excluding factors that
                                    are not relevant to the identified risks.</li>
                            </ul>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <h5 class="fw-bold">Alignment with Objectives:</h5>
                            <ul>
                                <li><strong>IS (Is):</strong> Ensures that a concept or system aligns with its intended
                                    objectives.</li>
                                <li><strong>Is Not (Is Not):</strong> Assists in maintaining focus on the primary goals
                                    by excluding features or characteristics that deviate from the objectives.</li>
                            </ul>
                        </div>

                        <div class="col-12">
                            <h5 class="fw-bold">Continuous Improvement:</h5>
                            <ul>
                                <li><strong>IS (Is):</strong> Facilitates a continuous improvement mindset by refining
                                    the definition over time.</li>
                                <li><strong>Is Not (Is Not):</strong> Promotes efficiency by eliminating aspects that do
                                    not contribute to improvement efforts.</li>
                            </ul>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <h5 class="fw-bold">Considerations:</h5>
                            <ul>
                                <li><strong>Dynamic Nature:</strong></li>
                                <ul>
                                    <li><strong>IS (Is):</strong> Acknowledges that definitions can evolve with changing
                                        requirements.</li>
                                    <li><strong>Is Not (Is Not):</strong> Emphasizes the need to revisit and update the
                                        analysis as the context changes.</li>
                                </ul>
                            </ul>
                        </div>

                        <div class="col-12">
                            <h5 class="fw-bold">Collaborative Tool:</h5>
                            <ul>
                                <li><strong>IS (Is):</strong> Serves as a tool for collaborative discussions and
                                    consensus building.</li>
                                <li><strong>Is Not (Is Not):</strong> Encourages teams to align on common understanding
                                    by addressing and resolving misconceptions.</li>
                            </ul>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <h5 class="fw-bold">Documentation Aid:</h5>
                            <ul>
                                <li><strong>IS (Is):</strong> Supports documentation efforts by providing a structured
                                    and clear foundation.</li>
                                <li><strong>Is Not (Is Not):</strong> Aids in maintaining documentation relevance by
                                    excluding obsolete or irrelevant information.</li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- ============================================
                WHY WHY CHART INSTRUCTION MODAL
    ============================================= --}}
    <div class="modal fade" id="observation-field-instruction-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Explanation of Data Fields</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-2">
                        <strong>Observation ID :&nbsp;</strong>
                        A unique identifier for each observation.
                    </div>
                    <div class="mb-2">
                        <strong>Date</strong>
                        When the observation was made.
                    </div>
                    <div class="mb-2">
                        <strong>Auditor :&nbsp;</strong>
                        Name of the auditor who identified the observation.
                    </div>
                    <div class="mb-2">
                        <strong>Auditee :&nbsp;</strong>
                        Name of the auditee who is responsible for area of observation.
                    </div>
                    <div class="mb-2">
                        <strong>Observation Description :&nbsp;</strong>
                        Detailed description of the observation.
                    </div>
                    <div class="mb-2">
                        <strong>Severity Level :&nbsp;</strong>
                        The severity level of the observation (e.g., Minor, Major, Critical,
                        Recommendation).
                    </div>
                    <div class="mb-2">
                        <strong>Area/Process :&nbsp;</strong>
                        The specific area or process where the observation occurred.
                    </div>
                    <div class="mb-2">
                        <strong>Observation Category :&nbsp;</strong>
                        The broad category to which the observation belongs (e.g., Documentation,
                        Equipment, Cleanroom, Data Integrity, etc.).
                    </div>
                    <div class="mb-2">
                        <strong>CAPA Required :&nbsp;</strong>
                        Specific actions that need to be taken to address the observation.
                    </div>
                    <div class="mb-2">
                        <strong>CAPA Due date :&nbsp;</strong>
                        Deadline for completing the corrective &amp; preventive actions.
                    </div>
                    <div>
                        <strong>Status :&nbsp;</strong>
                        The current status of the observation (e.g., Open, In Progress, Closed).
                    </div>

                </div>

            </div>
        </div>
    </div>

    {{-- ============================================
                MANAGEMENT REVIEW 1 INSTRUCTION MODAL
    ============================================= --}}
    <div class="modal fade" id="management-review-operations-instruction-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Instructions</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-4">
                        The organization shall plan, implement and control the processes (see 4.4) needed to meet the
                        requirements for the provision of products and services, and to implement the actions determined
                        in
                        Clause 6, by:
                    </div>
                    <ul>
                        <li>determining the requirements for the products and services;</li>
                        <li>
                            establishing criteria for:
                            <ol>
                                <li>the processes;</li>
                                <li>the acceptance of products and services;</li>
                            </ol>
                        </li>
                        <li>determining the resources needed to achieve conformity to the product and service
                            requirements;</li>
                        <li>implementing control of the processes in accordance with the criteria;</li>
                        <li>
                            determining, maintaining and retaining documented information to the extent necessary:
                            <ol>
                                <li>to have confidence that the processes have been carried out as planned;</li>
                                <li>to demonstrate the conformity of products and services to their requirements.</li>
                            </ol>
                        </li>
                    </ul>
                    <div class="mb-4">The output of this planning shall be suitable for the organization’s
                        operations.</div>
                    <div class="mb-4">The organization shall control planned changes and review the consequences of
                        unintended changes, taking action to mitigate any adverse effects, as necessary.</div>
                    <div>The organization shall ensure that outsourced processes are controlled (see 8.4).</div>

                </div>

            </div>
        </div>
    </div>

    {{-- ============================================
                MANAGEMENT REVIEW 2 INSTRUCTION MODAL
    ============================================= --}}
    <div class="modal fade" id="management-review-requirement_products_services-instruction-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Instructions</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <h5>Customer Communication</h5>
                    <p>Communication with customers shall include:</p>
                    <ul>
                        <li>Providing information relating to products and services;</li>
                        <li>Handling inquiries, contracts, or orders, including changes;</li>
                        <li>Obtaining customer feedback relating to products and services, including customer
                            complaints;</li>
                        <li>Handling or controlling customer property;</li>
                        <li>Establishing specific requirements for contingency actions, when relevant.</li>
                    </ul>

                    <h5>Determining the Requirements for Products and Services</h5>
                    <p>When determining the requirements for the products and services to be offered to customers, the
                        organization shall ensure that:</p>
                    <ul>
                        <li>The requirements for the products and services are defined, including:</li>
                        <ul>
                            <li>Any applicable statutory and regulatory requirements;</li>
                            <li>Those considered necessary by the organization;</li>
                        </ul>
                        <li>The organization can meet the claims for the products and services it offers.</li>
                    </ul>
                </div>

            </div>
        </div>
    </div>

    {{-- ============================================
                MANAGEMENT REVIEW 3 INSTRUCTION MODAL
    ============================================= --}}
    <div class="modal fade" id="management-review-design_development_product_services-instruction-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Instructions</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <h4>General</h4>
                    The organization shall ensure that externally provided processes, products and services conform to
                    requirements.
                    <ul>
                        <li>he approval of:</li>
                        <ol>
                            <li>products and services;</li>
                            <li>methods, processes and equipment;</li>
                            <li>the release of products and services;</li>
                        </ol>
                        <li>competence, including any required qualification of persons;</li>
                        <li>the external providers’ interactions with the organization;</li>
                        <li>control and monitoring of the external providers’ performance to be applied by the
                            organization;
                        </li>
                        <li>verification or validation activities that the organization, or its customer, intends to
                            perform at the external providers’ premises.</li>

                    </ul>
                    <div class="mb-4">
                        The organization shall determine the controls to be applied to externally provided processes,
                        products
                        and services when:
                    </div>
                    <ul>
                        <li>products and services from external providers are intended for incorporation into the
                            organization’s own products and services;</li>
                        <li>products and services are provided directly to the customer(s)by external providers on
                            behalf of
                            the organization;</li>
                        <li>a process, or part of a process, is provided by an external provider as a result of a
                            decision
                            by the organization.</li>
                    </ul>
                    <div class="mb-4">
                        The organization shall determine and apply criteria for the evaluation, selection, monitoring of
                        performance, and re-evaluation of external providers, based on their ability to provide
                        processes or
                        products and services in accordance with requirements. The organization shall retain documented
                        information of these activities and any necessary actions arising from the evaluations.
                    </div>
                    <h4>Type and extent of control</h4>
                    <div class="mb-4">
                        The organization shall ensure that externally provided processes, products and services do not
                        adversely affect the organization’s ability to consistently deliver conforming products and
                        services to
                        its customers.
                    </div>
                    <div class="mb-4">
                        The organization shall:
                    </div>
                    <ul>
                        <li>ensure that externally provided processes remain within the control of its quality
                            management
                            system;</li>
                        <li>define both the controls that it intends to apply to an external provider and those it
                            intends
                            to apply to the resulting output;</li>
                        <li>take into consideration:</li>
                        <ol>
                            <li>the potential impact of the externally provided processes, products and services on the
                                organization’s ability to consistently meet customer and applicable statutory and
                                regulatory
                                requirements;</li>
                            <li>the effectiveness of the controls applied by the external provider;</li>
                        </ol>
                        <li>determine the verification, or other activities, necessary to ensure that the externally
                            provided processes, products and services meet requirements.</li>
                    </ul>
                    <h4>Information for external providers</h4>
                    <div class="mb-4">
                        The organization shall ensure the adequacy of requirements prior to their communication to the
                        external provider.
                    </div>
                    <div class="mb-4"></div>
                    <ul>
                        <li>the processes, products and services to be provided;"</li>
                    </ul>

                </div>

            </div>
        </div>
    </div>

    {{-- ============================================
                MANAGEMENT REVIEW 4 INSTRUCTION MODAL
    ============================================= --}}
    <div class="modal fade" id="management-review-control_externally_provide_services-instruction-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Instructions</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <h4>General</h4>
                    <div class="mb-4">The organization shall ensure that externally provided processes, products and
                        services conform to requirements.</div>
                    <ul>
                        <li>
                            the approval of:
                            <ol>
                                <li>products and services;</li>
                                <li>methods, processes and equipment;</li>
                                <li>the release of products and services;</li>
                            </ol>
                        </li>
                        <li>competence, including any required qualification of persons;</li>
                        <li>the external providers’ interactions with the organization;</li>
                        <li>control and monitoring of the external providers’ performance to be applied by the
                            organization;</li>
                        <li>verification or validation activities that the organization, or its customer, intends to
                            perform at the external providers’ premises.</li>
                    </ul>
                    <div class="mb-4">The organization shall determine the controls to be applied to externally
                        provided processes, products and services when:</div>
                    <ul>
                        <li>products and services from external providers are intended for incorporation into the
                            organization’s own products and services;</li>
                        <li>products and services are provided directly to the customer(
                        <li>by external providers on behalf of the organization;</li>
                        <li>a process, or part of a process, is provided by an external provider as a result of a
                            decision by the organization.</li>
                    </ul>
                    <div class="mb-4">The organization shall determine and apply criteria for the evaluation,
                        selection, monitoring of performance, and re-evaluation of external providers, based on their
                        ability to provide processes or products and services in accordance with requirements. The
                        organization shall retain documented information of these activities and any necessary actions
                        arising from the evaluations.</div>
                    <h4>Type and extent of control</h4>
                    <div class="mb-4">The organization shall ensure that externally provided processes, products and
                        services do not adversely affect the organization’s ability to consistently deliver conforming
                        products and services to its customers.</div>
                    <div class="mb-4">The organization shall:</div>
                    <ul>
                        <li>ensure that externally provided processes remain within the control of its quality
                            management system;</li>
                        <li>define both the controls that it intends to apply to an external provider and those it
                            intends to apply to the resulting output;</li>
                        <li>
                            take into consideration:
                            <ol>
                                <li>the potential impact of the externally provided processes, products and services on
                                    the
                                    organization’s ability to consistently meet customer and applicable statutory and
                                    regulatory requirements;</li>
                                <li>the effectiveness of the controls applied by the external provider;</li>
                            </ol>
                        <li>determine the verification, or other activities, necessary to ensure that the externally
                            provided processes, products and services meet requirements.</li>
                    </ul>
                    <h4>Information for external providers</h4>
                    <div class="mb-4">The organization shall ensure the adequacy of requirements prior to their
                        communication to the external provider.</div>
                    <div class="mb-4">The organization shall communicate to external providers its requirements for:
                    </div>
                    <ul>
                        <li>the processes, products and services to be provided;"</li>
                    </ul>
                </div>

            </div>
        </div>
    </div>

    {{-- ============================================
                MANAGEMENT REVIEW 5 INSTRUCTION MODAL
    ============================================= --}}
    <div class="modal fade" id="management-review-production_service_provision-instruction-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Instructions</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <h4>Control of production and service provision</h4>
                    <div class="mb-4">The organization shall implement production and service provision under
                        controlled conditions. Controlled conditions shall include, as applicable:</div>
                    <ul>
                        <li>
                            the availability of documented information that defines:
                            <ol>
                                <li>the characteristics of the products to be produced, the services to be provided, or
                                    the activities to be performed;</li>
                                <li>the results to be achieved;</li>
                            </ol>
                        </li>
                        <li>the availability and use of suitable monitoring and measuring resources;</li>
                        <li>the implementation of monitoring and measurement activities at appropriate stages to verify
                            that criteria for control of processes or outputs, and acceptance criteria for products and
                            services, have been met;</li>
                        <li>the use of suitable infrastructure and environment for the operation of processes;</li>
                        <li>the appointment of competent persons, including any required qualification;</li>
                        <li>the validation, and periodic revalidation, of the ability to achieve planned results of the
                            processes for production and service provision, where the resulting output cannot be
                            verified by subsequent monitoring or measurement;</li>
                        <li>the implementation of actions to prevent human error;</li>
                        <li>the implementation of release, delivery and post-delivery activities.</li>
                    </ul>
                    <h4>Identification and traceability</h4>
                    <div class="mb-4">The organization shall use suitable means to identify outputs when it is
                        necessary to ensure the conformity of products and services.</div>
                    <div class="mb-4">The organization shall identify the status of outputs with respect to
                        monitoring and measurement requirements throughout production and service provision.</div>
                    <div class="mb-4">The organization shall control the unique identification of the outputs when
                        traceability is a requirement, and shall retain the documented information necessary to enable
                        traceability.</div>
                    <h4>Property belonging to customers or external providers</h4>
                    <div class="mb-4">The organization shall exercise care with property belonging to customers or
                        external providers while it is under the organization’s control or being used by the
                        organization.</div>
                    <div class="mb-4">The organization shall identify, verify, protect and safeguard customers’ or
                        external providers’ property provided for use or incorporation into the products and services.
                    </div>
                    <div class="mb-4">When the property of a customer or external provider is lost, damaged or
                        otherwise found to be unsuitable for use, the organization shall report this to the customer or
                        external provider and retain documented information on what has occurred.</div>
                    <div class="mb-4">NOTE A customer’s or external provider’s property can include materials,
                        components, tools and equipment, premises, intellectual property and personal data.</div>
                    <h4>Preservation</h4>
                    <div class="mb-4">The organization shall preserve the outputs during production and service
                        provision, to the extent necessary to ensure conformity to requirements.</div>
                    <div class="mb-4">NOTE Preservation can include identification, handling, contamination control,
                        packaging, storage, transmission or transportation, and protection.</div>
                    <h4>Post-delivery activities</h4>
                    <div class="mb-4">The organization shall meet requirements for post-delivery activities
                        associated with the products
                        and services.</div>
                    <div class="mb-4">In determining the extent of post-delivery activities that are required, the
                        organization shall
                        consider:</div>
                    <li>statutory and regulatory requirements;</li>
                    <li>the potential undesired consequences associated with its products and services;</li>
                    <li>the nature, use and intended lifetime of its products and services;</li>
                    <li>customer requirements;</li>
                    <li>customer feedback.</li>
                    <div class="mb-4">NOTE Post-delivery activities can include actions under warranty provisions,
                        contractual obligations such as maintenance services, and supplementary services such as
                        recycling or final disposal.</div>
                    <h4>Control of changes</h4>
                    <div class="mb-4">The organization shall review and control changes for production or service
                        provision, to the extent necessary to ensure continuing conformity with requirements.</div>
                    <div>The organization shall retain documented information describing the results of the review of
                        changes, the person(s) authorizing the change, and any necessary actions arising from the
                        review."</div>
                </div>

            </div>
        </div>
    </div>

    {{-- ============================================
                MANAGEMENT REVIEW 6 INSTRUCTION MODAL
    ============================================= --}}
    <div class="modal fade" id="management-review-release_product_services-instruction-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Instructions</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-4">The organization shall implement planned arrangements, at appropriate stages,
                        to verify that the product and service requirements have been met.</div>
                    <div class="mb-4">The release of products and services to the customer shall not proceed until
                        the planned arrangements have been satisfactorily completed, unless otherwise approved by a
                        relevant authority and, as applicable, by the customer.The organization shall retain documented
                        information on the release of products and services. The documented information shall include:
                    </div>
                    <ul>
                        <li>evidence of conformity with the acceptance criteria;</li>
                        <li>traceability to the person(s) authorizing the release."</li>
                    </ul>
                </div>

            </div>
        </div>
    </div>

    {{-- ============================================
                MANAGEMENT REVIEW 7 INSTRUCTION MODAL
    ============================================= --}}
    <div class="modal fade" id="management-review-control_nonconforming_outputs-instruction-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Instructions</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-4">The organization shall ensure that outputs that do not conform to their
                        requirements are identified and controlled to prevent their unintended use or delivery.</div>
                    <div class="mb-4">The organization shall take appropriate action based on the nature of the
                        nonconformity and its effect on the conformity of products and services. This shall also apply
                        to nonconforming products and services detected after delivery of products, during or after the
                        provision of services.</div>
                    <div class="mb-4">The organization shall deal with nonconforming outputs in one or more of the
                        following ways:</div>
                    <ul>
                        <li>correction;</li>
                        <li>segregation, containment, return or suspension of provision of products and services;</li>
                        <li>informing the customer;</li>
                        <li>obtaining authorization for acceptance under concession.</li>
                    </ul>
                    <div class="mb-4">Conformity to the requirements shall be verified when nonconforming outputs are
                        corrected.</div>
                    <h4>
                        The organization shall retain documented information that:
                    </h4>
                    <ul>
                        <li>describes the nonconformity;</li>
                        <li>describes the actions taken;</li>
                        <li>describes any concessions obtained;</li>
                        <li>identifies the authority deciding the action in respect of the nonconformity.</li>
                    </ul>
                </div>

            </div>
        </div>
    </div>

    {{-- ============================================
                MANAGEMENT REVIEW 8 INSTRUCTION MODAL
    ============================================= --}}
    <div class="modal fade" id="management-review-performance_evaluation-instruction-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Instructions</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <h4>General</h4>
                    <div class="mb-4">The organization shall determine:</div>
                    <ul>
                        <li>what needs to be monitored and measured;</li>
                        <li>the methods for monitoring, measurement, analysis and evaluation needed to ensure valid
                            results;
                        </li>
                        <li>when the monitoring and measuring shall be performed;</li>
                        <li>when the results from monitoring and measurement shall be analysed and evaluated.</li>
                    </ul>
                    <div class="mb-4">The organization shall evaluate the performance and the effectiveness of the
                        quality management system.</div>
                    <div class="mb-4">The organization shall retain appropriate documented information as evidence of
                        the results.</div>
                    <h4>Customer satisfaction</h4>
                    <div class="mb-4">The organization shall monitor customers’ perceptions of the degree to which
                        their needs and expectations have been fulfilled. The organization shall determine the methods
                        for obtaining, monitoring and reviewing this information.</div>
                    <div class="mb-4">NOTE Examples of monitoring customer perceptions can include customer surveys,
                        customer feedback on delivered products and services, meetings with customers, market-share
                        analysis, compliments, warranty claims and dealer reports.</div>
                    <h4>Analysis and evaluation</h4>
                    <div class="mb-4">The organization shall analyse and evaluate appropriate data and information
                        arising from monitoring and measurement.</div>
                    <div class="mb-4">The results of analysis shall be used to evaluate:</div>
                    <ul>
                        <li>conformity of products and services;</li>
                        <li>the degree of customer satisfaction;</li>
                        <li>the performance and effectiveness of the quality management system;</li>
                        <li>if planning has been implemented effectively;</li>
                        <li>the effectiveness of actions taken to address risks and opportunities;</li>
                        <li>the performance of external providers;</li>
                        <li>the need for improvements to the quality management system.</li>
                    </ul>
                    <div>NOTE Methods to analyse data can include statistical techniques.</div>
                </div>

            </div>
        </div>
    </div>

    {{-- ============================================
                Document Management System (DMS) - 1
    ============================================= --}}
    <div class="modal fade" id="document-management-system-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Major Versioning Instructions for Document Management System (DMS)</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <ol class="list-group">
                        <p>For the initial version of a document, set the Major Count to "1".


                        <p> For subsequent versions (2nd, 3rd, and so on), increment the Major Count accordingly:
                            2 for the 2nd version
                            3 for the 3rd version
                            And so forth, up to N.</p>

                        <p>This protocol ensures clear and organized version management within the DMS.
                            Please adhere to these instructions when creating or updating documents.</p>
                        </p>

                        <strong>Thank you for your cooperation!</strong>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    {{-- ============================================
                Document Management System (DMS) - 2
    ============================================= --}}
    <div class="modal fade" id="document-management-system-modal-minor">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Minor Versioning Instructions for Document Management System (DMS)</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <ol class="list-group">
                        <p>For the initial version of a document, set the Major Count to "X.O". </p>
                        <p> For subsequent versions (2nd, 3rd, and so on), increment the Major Count accordingly:
                            X.1 for the 2nd version
                            X.2 for the 3rd version
                            And so forth, up to X.9.</p>

                        <p>This protocol ensures clear and organized version management within the DMS.
                            Please adhere to these instructions when creating or updating documents.</p>

                        <strong>Thank you for your cooperation in!</strong>
                    </ol>
                </div>

            </div>
        </div>
    </div>
