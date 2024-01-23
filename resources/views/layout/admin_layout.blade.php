<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Welcome To | IBIGO Dashboard</title>
    <!-- Favicon-->
    <link rel="icon" href="{{ asset('assets/favicon.ico')}}" type="image/x-icon">

    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}" rel="stylesheet" />
    <!-- JQuery DataTable Css -->
    <link href="{{ asset('assets/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css')}}" rel="stylesheet">
    <!-- Waves Effect Css -->
    <link href="{{ asset('assets/plugins/node-waves/waves.css')}}" rel="stylesheet" />
    <!-- Animation Css -->
    <link href="{{ asset('assets/plugins/animate-css/animate.css')}}" rel="stylesheet" />

    <!-- Morris Chart Css-->
    <link href="{{ asset('assets/plugins/morrisjs/morris.css')}}" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="{{ asset('assets/css/style.css')}}" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="{{ asset('assets/css/themes/all-themes.css')}}" rel="stylesheet" />
    <link href="{{ asset('assets/css/font-awesome/font-awesome.min.css')}}" rel="stylesheet" />


    <!-- Wait Me Css -->
    <link href="{{ asset('assets/plugins/waitme/waitMe.css')}}" rel="stylesheet" />

    <!-- Bootstrap Select Css -->
    <link href="{{ asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}" rel="stylesheet" />
    <style>
        td,th{
            text-align:center !important;
        }
    </style>
</head>
<body class="theme-red">
        <!-- Page Loader -->
        <div class="page-loader-wrapper">
            <div class="loader">
                <div class="preloader">
                    <div class="spinner-layer pl-red">
                        <div class="circle-clipper left">
                            <div class="circle"></div>
                        </div>
                        <div class="circle-clipper right">
                            <div class="circle"></div>
                        </div>
                    </div>
                </div>
                <p>Please wait...</p>
            </div>
        </div>
        <!-- #END# Page Loader -->
        <!-- Overlay For Sidebars -->
        <div class="overlay"></div>
        <!-- #END# Overlay For Sidebars -->
        <!-- Search Bar -->
        <!-- <div class="search-bar">
            <div class="search-icon">
                <i class="material-icons">search</i>
            </div>
            <input type="text" placeholder="START TYPING...">
            <div class="close-search">
                <i class="material-icons">close</i>
            </div>
        </div> -->
        <!-- #END# Search Bar -->
        <!-- Top Bar -->
        <nav class="navbar">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                    <a href="javascript:void(0);" class="bars"></a>
                    <a class="navbar-brand" style="text-transform: uppercase" href="{{url('/admin')}}">IBIGO</a>
                </div>
                <!-- <div class="collapse navbar-collapse" id="navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">



                        <li class="pull-right"><a href="javascript:void(0);" class="js-right-sidebar" data-close="true"><i class="material-icons">more_vert</i></a></li>
                    </ul>
                </div> -->
            </div>
        </nav>
            <!-- #Top Bar -->
            <section>
            <!-- Left Sidebar -->
            <aside id="leftsidebar" class="sidebar">
                <!-- User Info -->
                <div class="user-info">
                    @if(!session('admin')[0]['avatar'])
                    <div class="image">
                        <img src="{{ asset('assets/images/user.png')}}" width="48" height="48" alt="User" />
                    </div>

                    @else
                    <div class="image">
                        <img src="{{ asset('storage/admin/profile/'.session('admin')[0]['avatar'])}}" width="48" height="48" alt="User" />
                    </div>
                    @endif

                    <div class="info-container">
                        <div style="text-transform: capitalize" class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                        {{session('admin')[0]['name']}}
                        </div>
                        <div class="email">
                        {{session('admin')[0]['email']}}


                        </div>
                        <div class="btn-group user-helper-dropdown">
                            <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                            <ul class="dropdown-menu pull-right">
                                <li><a href="{{url('/admin/profile')}}"><i class="material-icons">person</i>Profile</a></li>
                                <li role="separator" class="divider"></li>
                               <li><a href="{{ route('admin.logout') }}"><i class="material-icons">input</i>Sign Out</a></li>
                            </ul>
                        </div>
                    </div>
    </div>

                <!-- #User Info -->
                <!-- Menu -->
                <div class="menu">
                    <ul class="list">
                        <!-- <li class="header">MAIN NAVIGATION</li> -->
                        <li class="active">
                            <a href="{{ url('/admin')}}">
                                <i class="material-icons">home</i>
                                <span>Home</span>
                            </a>
                        </li>

                        @foreach(session('admin')[0]['user_permission'] as $permissions)
                            @if($permissions['permission']['permission'] == 'user-view')
                                <li>
                                    <a href="{{url('/admin/user')}}">
                                        <i class="material-icons">people</i>
                                        <span>Users</span>
                                    </a>
                                </li>
                            @endif
                        @endforeach
                                <li>
                                    <a href="javascript:void(0);" class="menu-toggle">
                                        <i class="material-icons">view_list</i>
                                        <span>Posts</span>
                                    </a>
                                    <ul class="ml-menu">
                                    @foreach(session('admin')[0]['user_permission'] as $permissions)
                                        @if($permissions['permission']['permission'] == 'post-view')
                                        <li>
                                            <a href="{{url('/admin/post')}}">
                                                <span>Post</span>
                                            </a>
                                        </li>
                                        @endif
                                        @if($permissions['permission']['permission'] == 'checkin-post-view')
                                        <li>
                                            <a href="{{url('/admin/checkin-post')}}">
                                                <span>Check in Post</span>
                                            </a>
                                        </li>
                                        @endif
                                        @if($permissions['permission']['permission'] == 'group-post-view')
                                        <li>
                                            <a href="{{url('/admin/group-post')}}">
                                                <span>Group Post</span>
                                            </a>
                                        </li>
                                        @endif
                                        @if($permissions['permission']['permission'] == 'spot-post-view')
                                        <li>
                                            <a href="{{url('/admin/spot-post')}}">
                                                <span>Spot Post</span>
                                            </a>
                                        </li>
                                        @endif
                                        @endforeach
                                    </ul>
                                </li>
                            @foreach(session('admin')[0]['user_permission'] as $permissions)
                            @if($permissions['permission']['permission'] == 'spot-view')
                                <li>
                                    <a href="{{url('/admin/spot')}}">
                                        <i class="material-icons">card_travel</i>
                                        <span>Spots</span>
                                    </a>
                                </li>
                            @endif
                            @if($permissions['permission']['permission'] == 'event-view')
                                <li>
                                    <a href="{{url('/admin/event')}}">
                                        <i class="material-icons">event_available</i>
                                        <span>Events</span>
                                    </a>
                                </li>
                            @endif
                            @if($permissions['permission']['permission'] == 'page-view')
                                <li>
                                    <a href="{{url('/admin/page')}}">
                                        <i class="material-icons">description</i>
                                        <span>Pages</span>
                                    </a>
                                </li>
                            @endif
                            @if($permissions['permission']['permission'] == 'group-view')
                                <li>
                                    <a href="{{url('/admin/group')}}">
                                        <i class="material-icons">group</i>
                                        <span>Groups</span>
                                    </a>
                                </li>
                            @endif
                        @endforeach
                        <li>
                            <a href="javascript:void(0);" class="menu-toggle">
                                <i class="material-icons">view_list</i>
                                <span>Settings</span>
                            </a>
                            <ul class="ml-menu">
                                @foreach(session('admin')[0]['user_permission'] as $permissions)
                                @if($permissions['permission']['permission'] == 'admin-view')

                                <li>
                                    <a href="{{url('admin/admin-users')}}">
                                    <i class="material-icons">
                                    person
                                    </i><span>Admin</span>

                                    </a>
                                </li>
                                @endif
                                @if($permissions['permission']['permission'] == 'role-view')
                                    <li>
                                        <a href="{{url('/admin/role')}}">
                                            <i class="material-icons">text_fields</i>
                                            <span>Roles</span>
                                        </a>
                                    </li>
                                @endif
                                @if($permissions['permission']['permission'] == 'permission-view')
                                    <li>
                                        <a href="{{url('/admin/permission')}}">
                                            <i class="material-icons">verified_user</i>
                                            <span>Permissions</span>
                                        </a>
                                    </li>
                                @endif
                                @if($permissions['permission']['permission'] == 'filter-view')
                                    <li>
                                        <a href="{{url('/admin/filters')}}">
                                            <i class="material-icons">assessment</i>
                                            <span>Filter</span>
                                        </a>
                                    </li>
                                @endif
                                @if($permissions['permission']['permission'] == 'interest-view')
                                    <li>
                                        <a href="{{url('/admin/interest')}}">
                                            <i class="material-icons">interests</i>
                                            <span>Interests</span>
                                        </a>
                                    </li>
                                @endif
                                @if($permissions['permission']['permission'] == 'expertise-view')
                                    <li>
                                        <a href="{{url('/admin/expertise')}}">
                                            <i class="material-icons">accessible</i>
                                            <span>Expertise</span>
                                        </a>
                                    </li>
                                @endif
                                @if($permissions['permission']['permission'] == 'review-view')
                                    <li>
                                        <a href="{{url('/admin/reviews')}}">
                                            <i class="material-icons">grade</i>
                                            <span>Reviews</span>
                                        </a>
                                    </li>
                                @endif
                                @endforeach
                                <li>
                                    <a href="javascript:void(0);" class="menu-toggle">
                                        <i class="material-icons">view_list</i>
                                        <span>Ibigo CMS</span>
                                    </a>
                                    <ul class="ml-menu">
                                        @foreach(session('admin')[0]['user_permission'] as $permissions)
                                        @if($permissions['permission']['permission'] == 'cms-view')
                                            <li>
                                                <a href="{{url('/admin/cms')}}">
                                                    <i class="material-icons">settings</i>
                                                    <span>CMS</span>
                                                </a>
                                            </li>
                                        @endif
                                        @if($permissions['permission']['permission'] == 'cms-detail-view')
                                            <li>
                                                <a href="{{url('/admin/cms-detail')}}">
                                                    <i class="material-icons">settings_applications</i>
                                                    <span>CMS - Details</span>
                                                </a>
                                            </li>
                                        @endif
                                        @endforeach
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <!-- #Menu -->
                <!-- Footer -->
                <!-- <div class="legal">
                    <div class="copyright">
                        &copy; 2021 <a href="javascript:void(0);">AdminBSB - Material Design</a>.
                    </div>
                    <div class="version">
                        <b>Version: </b> 1.0.5
                    </div>
                </div> -->
                <!-- #Footer -->
            </aside>
            <!-- #END# Left Sidebar -->
            <!-- Right Sidebar -->
            <aside id="rightsidebar" class="right-sidebar">
                <ul class="nav nav-tabs tab-nav-right" role="tablist">
                    <li role="presentation" class="active"><a href="#skins" data-toggle="tab">SKINS</a></li>
                    <li role="presentation"><a href="#settings" data-toggle="tab">SETTINGS</a></li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade in active in active" id="skins">
                        <ul class="demo-choose-skin">
                            <li data-theme="red" class="active">
                                <div class="red"></div>
                                <span>Red</span>
                            </li>
                            <li data-theme="pink">
                                <div class="pink"></div>
                                <span>Pink</span>
                            </li>
                            <li data-theme="purple">
                                <div class="purple"></div>
                                <span>Purple</span>
                            </li>
                            <li data-theme="deep-purple">
                                <div class="deep-purple"></div>
                                <span>Deep Purple</span>
                            </li>
                            <li data-theme="indigo">
                                <div class="indigo"></div>
                                <span>Indigo</span>
                            </li>
                            <li data-theme="blue">
                                <div class="blue"></div>
                                <span>Blue</span>
                            </li>
                            <li data-theme="light-blue">
                                <div class="light-blue"></div>
                                <span>Light Blue</span>
                            </li>
                            <li data-theme="cyan">
                                <div class="cyan"></div>
                                <span>Cyan</span>
                            </li>
                            <li data-theme="teal">
                                <div class="teal"></div>
                                <span>Teal</span>
                            </li>
                            <li data-theme="green">
                                <div class="green"></div>
                                <span>Green</span>
                            </li>
                            <li data-theme="light-green">
                                <div class="light-green"></div>
                                <span>Light Green</span>
                            </li>
                            <li data-theme="lime">
                                <div class="lime"></div>
                                <span>Lime</span>
                            </li>
                            <li data-theme="yellow">
                                <div class="yellow"></div>
                                <span>Yellow</span>
                            </li>
                            <li data-theme="amber">
                                <div class="amber"></div>
                                <span>Amber</span>
                            </li>
                            <li data-theme="orange">
                                <div class="orange"></div>
                                <span>Orange</span>
                            </li>
                            <li data-theme="deep-orange">
                                <div class="deep-orange"></div>
                                <span>Deep Orange</span>
                            </li>
                            <li data-theme="brown">
                                <div class="brown"></div>
                                <span>Brown</span>
                            </li>
                            <li data-theme="grey">
                                <div class="grey"></div>
                                <span>Grey</span>
                            </li>
                            <li data-theme="blue-grey">
                                <div class="blue-grey"></div>
                                <span>Blue Grey</span>
                            </li>
                            <li data-theme="black">
                                <div class="black"></div>
                                <span>Black</span>
                            </li>
                        </ul>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="settings">
                        <div class="demo-settings">
                            <p>GENERAL SETTINGS</p>
                            <ul class="setting-list">
                                <li>
                                    <span>Report Panel Usage</span>
                                    <div class="switch">
                                        <label><input type="checkbox" checked><span class="lever"></span></label>
                                    </div>
                                </li>
                                <li>
                                    <span>Email Redirect</span>
                                    <div class="switch">
                                        <label><input type="checkbox"><span class="lever"></span></label>
                                    </div>
                                </li>
                            </ul>
                            <p>SYSTEM SETTINGS</p>
                            <ul class="setting-list">
                                <li>
                                    <span>Notifications</span>
                                    <div class="switch">
                                        <label><input type="checkbox" checked><span class="lever"></span></label>
                                    </div>
                                </li>
                                <li>
                                    <span>Auto Updates</span>
                                    <div class="switch">
                                        <label><input type="checkbox" checked><span class="lever"></span></label>
                                    </div>
                                </li>
                            </ul>
                            <p>ACCOUNT SETTINGS</p>
                            <ul class="setting-list">
                                <li>
                                    <span>Offline</span>
                                    <div class="switch">
                                        <label><input type="checkbox"><span class="lever"></span></label>
                                    </div>
                                </li>
                                <li>
                                    <span>Location Permission</span>
                                    <div class="switch">
                                        <label><input type="checkbox" checked><span class="lever"></span></label>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </aside>
            <!-- #END# Right Sidebar -->
        </section>
        @yield('content')
    <!-- Jquery Core Js -->
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js')}}"></script>

    <!-- Bootstrap Core Js -->
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.js')}}"></script>

    <!-- Select Plugin Js -->
    <script src="{{ asset('assets/plugins/bootstrap-select/js/bootstrap-select.js')}}"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="{{ asset('assets/plugins/jquery-slimscroll/jquery.slimscroll.js')}}"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="{{ asset('assets/plugins/node-waves/waves.js')}}"></script>

    <!-- spot Js -->
    <script src="{{ asset('assets/js/pages/admin-spot/spot.js')}}"></script>

    <!-- Autosize Plugin Js -->
    <script src="{{ asset('assets/plugins/autosize/autosize.js')}}"></script>
    <!-- Moment Plugin Js -->
    <script src="{{ asset('assets/plugins/momentjs/moment.js')}}"></script>

    <!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script src="{{ asset('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>

    <script src="{{ asset('assets/js/pages/forms/basic-form-elements.js')}}"></script>
    <!-- Bootstrap Datepicker Plugin Js -->
    <script src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script>
    <!-- Jquery CountTo Plugin Js -->
    <script src="{{ asset('assets/plugins/jquery-countto/jquery.countTo.js')}}"></script>

    <script src="{{ asset('assets/plugins/ckeditor/ckeditor.js')}}"></script>

    <!-- TinyMCE -->
    <script src="{{ asset('assets/plugins/tinymce/tinymce.js')}}"></script>
    <!-- Morris Plugin Js -->
    <script src="{{ asset('assets/plugins/raphael/raphael.min.js')}}"></script>
    <script src="{{ asset('assets/plugins/morrisjs/morris.js')}}"></script>

    <!-- ChartJs -->
    <script src="{{ asset('assets/plugins/chartjs/Chart.bundle.js')}}"></script>

    <!-- Flot Charts Plugin Js -->
    <script src="{{ asset('assets/plugins/flot-charts/jquery.flot.js')}}"></script>
    <script src="{{ asset('assets/plugins/flot-charts/jquery.flot.resize.js')}}"></script>
    <script src="{{ asset('assets/plugins/flot-charts/jquery.flot.pie.js')}}"></script>
    <script src="{{ asset('assets/plugins/flot-charts/jquery.flot.categories.js')}}"></script>
    <script src="{{ asset('assets/plugins/flot-charts/jquery.flot.time.js')}}"></script>

    <!-- Sparkline Chart Plugin Js -->
    <script src="{{ asset('assets/plugins/jquery-sparkline/jquery.sparkline.js')}}"></script>

    <!-- Custom Js -->
    <script src="{{ asset('assets/js/admin.js')}}"></script>
    <script src="{{ asset('assets/js/pages/index.js')}}"></script>

    <script src="{{ asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>
    <!-- Demo Js -->

     <!-- Ckeditor -->

     <script src="{{ asset('assets/js/admin.js')}}"></script>
    <script src="{{ asset('assets/js/pages/forms/editors.js')}}"></script>

    <script src="{{ asset('assets/plugins/jquery-datatable/jquery.dataTables.js')}}"></script>
    <script src="{{ asset('assets/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js')}}"></script>
    <script src="{{ asset('assets/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js')}}"></script>

    <script src="{{ asset('assets/plugins/jquery-datatable/extensions/export/buttons.flash.min.js')}}"></script>
    <script src="{{ asset('assets/plugins/jquery-datatable/extensions/export/jszip.min.js')}}"></script>
    <script src="{{ asset('assets/plugins/jquery-datatable/extensions/export/pdfmake.min.js')}}"></script>
    <script src="{{ asset('assets/plugins/jquery-datatable/extensions/export/vfs_fonts.js')}}"></script>
    <script src="{{ asset('assets/plugins/jquery-datatable/extensions/export/buttons.html5.min.js')}}"></script>
    <script src="{{ asset('assets/plugins/jquery-datatable/extensions/export/buttons.print.min.js')}}"></script>
    <script src="{{ asset('assets/js/demo.js')}}"></script>
    <script src="{{url('https://use.fontawesome.com/789d6a67d2.js')}}"></script>
    <script src="{{ asset('assets/js/ckeditor.js')}}"></script>
    <script src="{{ asset('assets/js/custom.js')}}"></script>

<script>
	ClassicEditor
		.create( document.querySelector( '#description' ), {
			// toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ]
		} )
		.then( editor => {
			window.editor = editor;
		} )
		.catch( err => {
			console.error( err.stack );
		} );
        ClassicEditor
		.create( document.querySelector( '#description1' ), {
			// toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ]
		} )
		.then( editor => {
			window.editor = editor;
		} )
		.catch( err => {
			console.error( err.stack );
		} );
</script>
</body>



</html>
