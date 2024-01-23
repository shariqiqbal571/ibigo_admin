<!DOCTYPE HTML>
<html lang="en">


<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="viewport"
        content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <link rel="icon" href="{{asset('ibigo-web/images/a.ico')}}">

    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{url('https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css')}}" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{asset('ibigo-web/styles/bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('ibigo-web/styles/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('ibigo-web/styles/custom.css')}}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{asset('ibigo-web/fonts/css/fontawesome-all.min.css')}}">
    <link rel="manifest" href="{{asset('ibigo-web/_manifest.json" data-pwa-version="set_in_manifest_and_pwa_js')}}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('ibigo-web/app/icons/icon-192x192.png')}}">
    <script src="{{url('https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js')}}"></script>


</head>

<body class="theme-light">

    <!-- <div id="preloader">
        <div class="spinner-border color-highlight" role="status"></div>
    </div> -->

    <div class="page">

        <div class="header header-auto-show header-fixed header-logo-center">
            <a href="{{url('/')}}" class="header-title"><img src="{{asset('ibigo-web/images/logop.png')}}" alt="" width="70px"></a>
            <a href="#" data-menu="menu-main" class="header-icon header-icon-1 show-side-bar"><i class="fas fa-bars"></i></a>
            <a href="#" data-toggle-theme class="header-icon header-icon-6 show-on-theme-dark"><i
                    class="fas fa-sun"></i></a>
            <a href="#" data-toggle-theme class="header-icon header-icon-6 show-on-theme-light"><i
                    class="fas fa-moon"></i></a>
            <input type="hidden" class="userId" value="{{Auth::user()->id}}" >
        </div>

        @if(request()->route()->uri == 'chat')
        <div id="footer-bar" class="d-flex" style="display: none !important;">
            <div class="ml-3 speach-icon friend-list menu-call" style="display: none;">
                <a href="#" class="bg-gray-dark color-white mr-2" data-menu="menu-call"><i class="fa fa-users"></i></a>
            </div>
            <div class="ml-3 flex-fill speach-input">
                <input type="text" class="message-box form-control" placeholder="Enter your Message here">
            </div>
            <div class="ml-3 speach-icon">
                <a href="#" class="message-btn bg-magenta-dark color-white mr-2"><i class="fa fa-arrow-up"></i></a>
            </div>
        </div>
        @elseif(request()->route()->uri == 'group-chat')
        @else
        <div id="footer-bar" class="footer-bar-6">
            <a href="{{url('/friends')}}" @if(request()->route()->uri == 'friends') class="active-nav" @endif><i class="fa fa-user-friends"></i><span>Connect</span></a>
            <a href="{{url('/search')}}" @if(request()->route()->uri == 'search') class="active-nav" @endif><i class="fas fa-search"></i><span>Search</span></a>
            <a href="{{url('/')}}" class="circle-nav @if(request()->route()->uri == '/') active-nav @endif"><i class="fa fa-home"></i><span>Home</span></a>
            <a href="{{url('/todo/go-list')}}" @if(request()->route()->uri == 'todo/go-list') class="active-nav" @endif><i class="fa fa-tasks"></i><span>To Do</span></a>
            <a href="{{url('/profile')}}" @if(request()->route()->uri == 'profile') class="active-nav" @endif><i class="fas fa-user"></i><span>Profile</span></a>
        </div>
        @endif


        <div class="page-title page-title-fixed">
            <h1> <a href="{{url('/')}}"><img src="{{asset('ibigo-web/images/logop.png')}}" alt="" width="70px"></a> </h1>
            <div class="content mb-0 mt-0 " style="width: 50%;;">
                <div class=" search-dark shadow-xl  border-0 bg-theme rounded-sm bottom-0">
                    <i class="fas fa-search px-3"></i>
                    <input type="text" class="border-0 pb-2 pt-2 search"
                        placeholder=" Vind de beste spots om te eten, drinken, shoppen of bezoeken…...   " data-search>
                </div>
            </div>
            <a href="{{url('/notifications')}}" class="page-title-icon shadow-xl bg-theme color-theme"><i class="fas fa-bell"></i></a>
            <a href="#" class="page-title-icon shadow-xl bg-theme color-theme show-on-theme-light" data-toggle-theme><i
                    class="fa fa-moon"></i></a>
            <a href="#" class="page-title-icon shadow-xl bg-theme color-theme show-on-theme-dark" data-toggle-theme><i
                    class="fa fa-lightbulb color-yellow-dark"></i></a>
            <a href="#" class="page-title-icon shadow-xl bg-theme color-theme show-side-bar" data-menu="menu-main"><i
                    class="fa fa-bars"></i></a>
        </div>
    </div>
        <div class="page-title-clear">
            <div id="menu-main" class="menu menu-box-left rounded-0" 
                data-menu-width="280" style="display: block; width: 280px; ">
                <div class="card rounded-0 bg-6" data-card-height="150">
                    <div class="card-top"><a class="close-menu float-right mr-2 text-center mt-3 icon-40 notch-clear"
                            href="#"><i class="fa fa-times color-white"></i></a></div>
                    <div class="card-bottom">
                        <h1 class="color-white pl-3 mb-n1 font-28">IBIGO</h1>
                        <p class="mb-2 pl-3 font-12 color-white opacity-50">Welke spot is hot</p>
                    </div>
                    <div class="card-overlay bg-gradient"><img src="{{asset('ibigo-web/images/4.png')}}" alt="" width="100%"></div>
                </div>

                <div class="mt-4">
                    <h6 class="menu-divider">Menu</h6>
                    <div class="list-group list-custom-small list-menu"><a href="{{url('/')}}"><i
                                class="fa fa-home gradient-green color-white"></i><span>Home</span></a><a
                            href="{{url('/search')}}"><i class="fa fa-search  bg-magenta-dark"></i><span>Search</span></a><a
                            href="{{url('/todo/plan')}}"><i
                                class="fa fa-tasks gradient-pink color-white"></i><span>Agenda</span></a><a
                            href="{{url('/friends')}}"><i
                                class="fa fa-user-friends gradient-brown color-white"></i><span>Connect</span></a><a
                            href="{{url('/profile')}}"><i
                                class="fas fa-user-alt gradient-teal color-white"></i><span>Profiel</span></a><a
                            href="{{url('/chat')}}"><i class="fas fa-comment bg-magenta-dark"></i>
                            <span>Chat</span></a>
                        <a href="{{url('/group-chat')}}"><i class="fas fa-comments gradient-red color-white"></i><span>Group
                                Chat</span></a>
                    </div>
                    <h6 class="menu-divider ng-star-inserted mt-4">Information</h6>
                    <div class="list-group list-custom-small list-menu ng-star-inserted information">
                        
                    </div>
                    <h6 class="menu-divider mt-4">Instellingen</h6>
                    <div class="list-group list-custom-small list-menu"><a href="{{url('/interest')}}"><i
                                class="fas fa-cog bg-magenta-light color-white p-0"></i><span>Intereses</span></a><a
                            href="{{url('/notifications')}}"><i
                                class="fa fa-bell gradient-yellow color-white"></i><span>Notificaties</span></a>

                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                <i class="fa fa-lock gradient-orange color-white"></i><span>logOut</span>
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>

                    </div>
                </div>
            </div>
        </div>

        @yield('content')

        @if(Session::has('success'))
            <div id="menu-success-2" class="menu menu-active menu-box-bottom rounded-m" data-menu-height="185" data-menu-effect="menu-over"
            style="display: block; height: 185px;">
                <div class="menu-title">
                    <i class="fa fa-check-circle scale-box float-left mr-3 ml-3 fa-4x color-green-dark"></i>
                    <p class="color-magenta-dark">{{Session::get('success')}}</p>
                    <h1>Success</h1>
                    <a href="#" class="close-menu"><i class="fa fa-times-circle"></i></a>
                </div>

                <!-- Colors Menu-->
                <div id="menu-colors" class="menu menu-box-bottom rounded-m" data-menu-load="menu-colors.html"
                data-menu-height="480"></div>
            </div>
        @endif
       
    <script src="{{url('https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js')}}" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="{{asset('ibigo-web/scripts/app.js')}}"></script>
    <script type="text/javascript" src="{{asset('ibigo-web/scripts/jquery.js')}}"></script>
    <script type="text/javascript" src="{{asset('ibigo-web/scripts/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('ibigo-web/scripts/custom.js')}}"></script>
    <script type="text/javascript" src="{{asset('ibigo-web/scripts/jquery-ui.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('ibigo-web/scripts/ajax.js')}}"></script>
</body>
</html>