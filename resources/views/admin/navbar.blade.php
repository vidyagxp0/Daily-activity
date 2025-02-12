<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light" style="background-color: #00838F">
    <!-- Left navbar links -->
    <ul class="navbar-nav" >
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button" style="color: #fff"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ URL::to('admin/dashboard') }}" class="nav-link" style="color: #fff; font-size: 18px;">Home</a>

        </li>

    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <div class="image">
                    <img width="30" src="{{ asset('admin/dist/img/user8-128x128.jpg') }}" class="img-circle elevation-2" alt="User Image">
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right card card-widget widget-user">
                    <div class="widget-user-header" style="background-color: #159990; color: white;">
                        <h3 class="widget-user-username">
                            <!-- @if (Auth::guard('admin')->check())
                                {{ Auth::guard('admin')->user()->name }}
                            @endif -->
                        </h3>
                        <h5 class="widget-user-desc">
                            @if (Auth::guard('admin')->check())
                                {{ Auth::guard('admin')->user()->role }}
                            @endif
                        </h5>
                    </div>
                    <div class="widget-user-image">
                        <img class="img-circle elevation-2" src="{{ asset('admin/dist/img/user8-128x128.jpg') }}" alt="User Avatar">
                    </div>
                    <div class="card-footer m-2">
                        <center>
                            <a href="{{ url('admin/logout') }}" class="btn" style="background-color: #159990; color: white;"><i class="fas fa-sign-out-alt"></i>LogOut</a>
                        </center>
                    </div>
                </div>
            </div>
        </li>
    
        @if (session()->has('adminLogin'))
            @if (session()->get('adminLogin') == true)
                <li class="nav-item">
                    <a href="{{ URL::to('/admin/logout') }}">
                        <button class="btn btn-danger" style="background-color: #159990; border-color: #159990; color: white;">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </a>
                </li>
            @endif
        @endif
    </ul>
    
</nav>
<!-- /.navbar -->


<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-danger elevation-4">
    <!-- Brand Logo -->
                     <div class="logo-container">
                        <div class="logo"style="text-align: left;" >
                            <img src="{{ asset('user/images/vidhyagxp.png') }}"  
                            alt="" 
                            class="logo-img" 
                            style="width: 160px; height: auto; pointer-events: none; margin-right: 55px" class="w-80">
                        </div>
                    </div>
 

    <!-- Sidebar -->
    <div class="sidebar">
        @if (session()->has('adminLogin'))
            @if (session()->get('adminLogin') == true)
            @endif
        @endif


        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                    aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-flat nav-child-indent nav-sidebar flex-column " data-widget="treeview"
                role="menu" data-accordion="false">
                <li class="nav-header">Home</li>

                <li class="nav-item">
                    <a href="{{ URL('admin/dashboard') }}"
                        class="nav-link @php
                if($mainmenu=="Dashboard"){
                echo "active";
            } @endphp">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard

                        </p>
                    </a>
                </li>

                <li class="nav-item {{ $mainmenu == 'User Management' ? 'menu-open' : '' }} ">
                    <a href="#"
                        class="nav-link  @php
                     if($mainmenu=="User Management"){
                                                echo "active";
                                            } @endphp">
                        <i class="nav-icon fa fa-users"></i>
                        <p>
                            User Management
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">


                        <li class="nav-item">
                            <a href="{{ route('user_management.index') }}"
                                class="nav-link @php
                                   if($submenu=="Login Account"){
                                     echo "active";
                                  } @endphp">
                                <i class="far fa-plus-square nav-icon"></i>
                                <p>Login</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('role_groups.index') }}"
                                class="nav-link @php
                         if($submenu=="Role Permission"){
                            echo "active";
                        } @endphp">
                                <i class="fa fa-user-circle nav-icon"></i>
                                <p>Role Permission</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('GroupPermission.index') }}"
                                class="nav-link @php
                if($submenu=="Group Permission"){
                            echo "active";
                        } @endphp">
                                <i class="fa fa-users nav-icon"></i>
                                <p>Group Permission</p>
                            </a>
                        </li>

                    </ul>
                </li>
                {{-- <li class="nav-item">
                            <a href="{{ URL('admin/blacklist') }}"
                                class="nav-link 
                                @php
                                if($mainmenu=="Black List IP"){
                                    echo "active";
                                } 
                                @endphp">
                                <i class="fas fa-ban nav-icon"></i>
                                <p>
                                    Black List IP
                                </p>
                            </a>
                        </li> --}}
                <li class="nav-item">
                    <a href="{{ URL('admin/usermonitoring') }}"
                        class="nav-link 
                        @php
                        if($mainmenu=="User Monitoring"){
                            echo "active";
                        } 
                        @endphp">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            User Monitoring
                        </p>
                    </a>
                </li>

                <li class="nav-item {{ $mainmenu == 'System Configuration' ? 'menu-open' : '' }} ">
                    <a href="#"
                        class="nav-link  @php
                if($mainmenu=="System Configuration"){
                echo "active";
            } @endphp">
            <i class="nav-icon fa fa-cog"></i>
                        <p>
                            System Configuration
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">


                        <li class="nav-item">
                            <a href="{{ URL::to('admin/department') }}"
                                class="nav-link @php
                       if($submenu=="Department"){
                            echo "active";
                        } @endphp">
                                <i class="far fa-building nav-icon"></i>
                                <p>Department</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('document_types.index') }}"
                                class="nav-link @php
                   if($submenu=="Document"){
                            echo "active";
                        } @endphp">
                                <i class="fa fa-book nav-icon"></i>
                                <p>Document Type</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('document_subtypes.index') }}"
                                class="nav-link @php
                  if($submenu=="Document Subtype"){
                            echo "active";
                        } @endphp">
                                <i class="far fa-edit nav-icon"></i>
                                <p>Document SubType</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('documentlanguage.index') }}"
                                class="nav-link @php
                  if($submenu=="Document Language"){
                            echo "active";
                        } @endphp">
                                <i class="fas fa-pen nav-icon"></i>
                                <p>Document Language</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item {{ $mainmenu == 'Division & Process' ? 'menu-open' : '' }} ">
                    <a href="#"
                        class="nav-link  @php
                       if($mainmenu=="Division & Process"){
                                                echo "active";
                                            } @endphp">
                        <i class="nav-icon fa fa-spinner"></i>
                        <p>
                            Division & Process
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">


                        <li class="nav-item">
                            <a href="{{ route('division.index') }}"
                                class="nav-link @php
                                if($submenu=="Division"){
                                                            echo "active";
                                                        } @endphp">
                                <i class="fas fa-chart-pie nav-icon"></i>
                                <p>Division</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('process.index') }}"
                                class="nav-link @php
                        if($submenu=="Process"){
                            echo "active";
                        } @endphp">
                                <i class="fas fa-tasks nav-icon"></i>
                                <p>Process</p>
                            </a>
                        </li>

                    </ul>
                </li>

                

                <li class="nav-item {{ $mainmenu == 'Control Management' ? 'menu-open' : '' }} ">
                    <a href="#"
                        class="nav-link  @php
                    if($mainmenu=="Control Management"){
                                                echo "active";
                                            } @endphp">
                        <i class="nav-icon fa fa-briefcase"></i>
                        <p>
                            Control Management
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">




                        <li class="nav-item">
                            <a href="{{ route('printcontrol.index') }}"
                                class="nav-link @php
                     if($submenu=="Print Control"){
                            echo "active";
                        } @endphp">
                                <i class="fa fa-print nav-icon"></i>
                                <p>Print Control</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('downloadcontrol.index') }}"
                                class="nav-link @php
                      if($submenu=="Download Control"){
                            echo "active";
                        } @endphp">
                                <i class="fa fa-download nav-icon"></i>
                                <p>Download Control</p>
                            </a>
                        </li>

                    </ul>
                </li>

                  <li class="nav-item {{ $mainmenu == 'Product & Material' ? 'menu-open' : '' }} ">
                    <a href="#"
                        class="nav-link  @php
              if($mainmenu=="Product & Material"){
                                                echo "active";
                                            } @endphp">
                        <i class="nav-icon fa fa-window-restore"></i>
                        <p>
                            Product & Material
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">




                        <li class="nav-item">
                            <a href="{{ route('product.index') }}"
                                class="nav-link @php
                       if($submenu=="Product"){
                            echo "active";
                        } @endphp">
                                <i class="fa fa-database nav-icon"></i>
                                <p>Product</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('material.index') }}"
                                class="nav-link @php
                       if($submenu=="Material"){
                            echo "active";
                        } @endphp">
                                <i class="fa fa-retweet nav-icon"></i>
                                <p>Material Control</p>
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="nav-item">
                    <a href="{{ URL('admin/risk-level') }}"
                        class="nav-link @php
                      if($mainmenu=="risk-level"){
                echo "active";
            } @endphp">
                        <i class="nav-icon fa fa-exclamation-triangle"></i>
                        <p>
                            Risk Level

                        </p>
                    </a>
                </li>


                </li>


            </ul>
        </nav>
       
    </div>
    
    <style>
        .brand-link {
            height: 60px;
        }

        .logo-container {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .logo {
            background-color: white;
            border-radius: 10px;
            padding: 10px;
        }

        .sidebar .nav-link {
            padding: 10px 15px;
            font-size: 14px;
            color: #c2c7d0;
        }

        .sidebar .nav-link.active {
            background-color: #343a40;
            color: #ffffff;
            font-weight: bold;
        }

        .sidebar .nav-link i {
            margin-right: 10px;
        }

        .sidebar .nav-item {
            margin-bottom: 5px;
        }

        .sidebar .nav-pills .nav-treeview > .nav-item > .nav-link {
            padding-left: 30px;
        }

        .sidebar-dark-danger {
            background-color: #343a40;
        }

        .nav-pills .nav-link:hover {
            background-color: #495057;
            color: #fff;
        }

        .nav-treeview > .nav-item > .nav-link:hover {
            background-color: #495057;
            color: #fff;
        }

        /* Add some smooth transitions for hover effects */
        .sidebar .nav-link, .sidebar .nav-link:hover {
            transition: background-color 0.3s, color 0.3s;
        }
    </style>
</aside>










<style>
    .brand-link {
        height: 60px;
        }

        .logo-container {
        align-items: center;
    }
    .logo {
        background:white;
        padding-left: 60px;
        padding-top: 10px;
        padding-bottom: 10px;

     }
</style>