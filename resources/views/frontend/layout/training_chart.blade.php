<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <title>Vidyagxp - Software</title>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css"
        integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">



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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.14.0/themes/base/jquery-ui.min.css"
        integrity="sha512-F8mgNaoH6SSws+tuDTveIu+hx6JkVcuLqTQ/S/KJaHJjGc8eUxIrBawMnasq2FDlfo7FYsD8buQXVwD+0upbcA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{-- @toastr_css --}}
</head>

<body>

    <style>
        #tms-dashboard {
            padding: 20px 0px;
            background: #4274da;
            min-height: 0 !important;
        }

        #create-record-button {
            display: none;
            margin-left: auto;
        }

        .cctab {
            display: flex;
            justify-content: left;
            margin-bottom: 20px;
            padding: 10px;
        }

        .cctablinks {
            background-color: #ffffff;
            border-radius: 5px;
            padding: 6px 12px;
            margin: 0 5px;
            cursor: pointer;
            font-size: 16px;
            color: #333;
            border: none;
        }

        .cctablinks:hover {
            background-color: #ddd;
            color: #000;
        }

        .cctablinks.active {
            background-color: #3a424b;
            /* background-color: #007bff; */
            color: white;
        }

        .cctabcontent {
            padding: 20px;
            border: 1px solid #ccc;
            border-top: none;
        }
    </style>


    <header>
        
        {{-- Header Top --}}
        <div class="container-fluid header-top">
            <div class="container">
                <div class="text-center text-light">
                    <small>
                        
                    </small>
                </div>
            </div>
        </div>


        <div class="container-fluid header-middle">
            <div>
                <div class="middle-head">
                    <div class="logo-container">
                        <div class="logo">
                            <img src="{{ asset('user/images/connexo.png') }}" alt="..." class="w-100 h-100"
                                style="scale: 1">
                        </div>
                        <div class="logo" style="margin-left: 15px;">
                            {{-- <img src="{{ asset('user/images/symbiotec_pharmalab_pvt_ltd__logo.jpg') }}"
                                alt="..."class="w-100 h-100"
                                style="filter: none; scale: 1.8; max-width: 70px; margin: auto; margin-top: 7px; margin-bottom: 20px;"> --}}
                        </div>
                        {{-- <div class="logo">
                                <img src="{{ asset('user/images/agio.jpg') }}" alt="..." class="w-100 h-100">
                            </div> --}}
                    </div>
                    <!-- <div class="search-bar">
                            <form action="#" class="w-100">
                                <label for="search"><i class="fa-solid fa-magnifying-glass"></i></label>
                                <input id="searchInput" type="text" name="search" placeholder="Search">
                                <div data-bs-toggle="modal" data-bs-target="#advanced-search">Advanced Search</div>
                            </form>
                        </div> -->
                    <div class="icon-grid">

                        @if (Auth::guard('employee')->user())
                            <div class="icon-drop">
                                <div class="icon">
                                    <i class="fa-solid fa-user-tie"></i>
                                    {{ Auth::guard('employee')->user()->employee_name }}
                                    <i class="fa-solid fa-angle-down"></i>
                                </div>
                                <div class="icon-block small-block">
                                    <div data-bs-toggle="modal" data-bs-target="#about-modal">About</div>
                                    <div><a href="{{ route('logout-employee') }}">Log Out</a></div>
                                </div>
                            </div>
                        @else
                            <div class="icon-drop">
                                <div class="icon">
                                    <i class="fa-solid fa-user-tie"></i>
                                    @if (Auth::user())
                                        {{ Auth::user()->name }}
                                    @else
                                        Amit Guru
                                    @endif
                                    <i class="fa-solid fa-angle-down"></i>
                                </div>
                                <div class="icon-block small-block">
                                    <div data-bs-toggle="modal" data-bs-target="#about-modal">About</div>
                                    <div><a href="/helpdesk-personnel">Helpdesk Personel</a></div>
                                    <div><a href="{{ route('logout') }}">Log Out</a></div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </header>



    {{-- ======================================
                    DASHBOARD
    ======================================= --}}

    <div id="tms-dashboard">
        <div class="container-fluid">
            <div class="dashboard-container">
            </div>
        </div>
    </div>





    <style>
        .table thead th {
            background-color: #4274daba;
            color: rgb(2, 2, 2);
        }

        .inner-block {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .heading-tms {
            font-size: 19px;
            font-weight: bold;
            color: #030303;
            margin-bottom: 15px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .table th,
        .table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .table thead th {
            background-color: #4274daba;
            color: rgb(2, 2, 2);
        }

        .table tbody tr:hover {
            background-color: #f1f1f1;
        }

        /* Pagination Styles */
        .pagination {
            justify-content: center;
            margin-top: 15px;
        }

        .btn {
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;

        }

        .btn-outline {
            background-color: transparent;
            border: 1px solid #4274da;
            color: #4274da;
            transition: background-color 0.3s, color 0.3s;
        }

        .btn-outline:hover {
            background-color: #4274da;
            color: white;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {

            .table th,
            .table td {
                padding: 8px;
                font-size: 14px;
            }

            .heading-tms {
                font-size: 20px;
            }
        }
    </style>

@include('frontend.layout.training_child') 


</body>

</html>
