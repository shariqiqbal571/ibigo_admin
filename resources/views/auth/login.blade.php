@extends('../layouts/web_layout')
@section('title', 'Ibigo | Signin')
@section('content')



<body>
    <div id="preloader">
        <div class="spinner-border color-highlight" role="status"></div>
    </div>

    <div id="page">

        <div class="header header-fixed header-logo-center ">
            <a href="index.html" class="header-title pb-5"><img src="{{asset('ibigo-web/images/logop.png')}}" alt="" width="70px"></a>
        </div>

        <div id="footer-bar" class="footer-bar-6">
            <a href="{{asset('ibigo-web/index-components.html')}}"><i class="fa fa-user-friends"></i><span>Connect</span></a>
            <a href="{{asset('ibigo-web/index-pages.html')}}" class="active-nav"><i class="fas fa-search"></i><span>Zoeken</span></a>
            <a href="{{asset('ibigo-web/index.html')}}" class="circle-nav"><i class="fa fa-home"></i><span>Home</span></a>
            <a href="{{asset('ibigo-web/index-projects.html')}}"><i class="fa fa-tasks"></i><span>To Do</span></a>
            <a href="#" data-menu="menu-main"><i class="fas fa-user"></i><span>Profile</span></a>
        </div>


        <div class="page-content pt-5 pb-5">

            <div class="card card-1" style="background-image:url({{asset('ibigo-web/images/11.jpg')}}); height: 800px;">
                <div class="card-center">

                    <div class=" text-center pt-5">
                        <p class="font-600  mb-1 font-18 color-magenta-dark pt-5">Let's Get Started</p>
                        <h1 class="font-700 color-white">Sign In</h1>
                    </div>
                    <div class=" text-center">
                        <div class="  information">
                            <i class="fas fa-check" style="color: green ;"></i>
                            <span class="color-white font-14">Ontvang aanbevelingen van vrienden, spots, events en
                                Ibigo</span>
                        </div>
                    </div>
                    <div class=" text-center">
                        <div class="  information">
                            <i class="fas fa-check  " style="color: green ;"></i>
                            <span class="color-white font-14">Plan uitjes en events met jouw vrienden via de Ibigo
                                planner.</span>
                        </div>
                    </div>
                    <div class=" text-center">
                        <div class="  information">
                            <i class="fas fa-check  " style="color: green ;"></i>
                            <span class="color-white font-14">Plan uitjes en events met jouw vrienden via de Ibigo
                                planner.</span>
                        </div>
                    </div>
                    <div class=" text-center">
                        <div class="  information">
                            <i class="fas fa-check  " style="color: green ;"></i>
                            <span class="color-white font-15 ">
                                Maak connecties met andere gebruikers, spots en events</span>
                        </div>
                    </div>
                    <div class=" text-center">
                        <div class="  information">
                            <i class="fas fa-check" style="color: green ;"></i>
                            <span class="color-white font-14 pb-4">
                                Vind de leukste en hipste spots & events afgestemd op jouw<br> persoonlijke
                                voorkeuren. </span>
                        </div>
                    </div>
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                    <div class="container">
                        <div class="content px-4">
                                <div class="input-style input-light has-icon input-style-1 input-required">
                                    <i class="input-icon fas fa-envelope"></i>
                                    <span>Email</span>
                                    <em>(required)</em>
                                    <input id="email" type="email" placeholder="Email" class="@error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email" autofocus>

                                </div>
                                    @error('email')
                                        <span role="alert" class="text-danger"><strong>{{ $message }}</strong>
                                    @enderror
                                <div class="input-style input-light has-icon input-style-1 input-required">
                                    <i class="input-icon fa fa-lock"></i>
                                    <span>Passsword</span>
                                    <em>(required)</em>
                                    <input id="password-confirm" placeholder="Password" class="@error('password') is-invalid @enderror"  type="password"  name="password" autocomplete="new-password">
                                
                                </div>
                                    @error('password')
                                        <span role="alert" class="text-danger"><strong>{{ $message }}</strong>
                                    @enderror
                                <div class="row pt-3 mb-3">
                                    <div class="col-6 text-left font-11">
                                        <a class="color-white opacity-50" href="{{ route('password.request') }}">Wachtwoord vergeten?</a>
                                    </div>
                                    <div class="col-6 text-right font-11">
                                        <a class="color-white opacity-50" href="{{ route('register') }}">Creëer een nieuw
                                            account</a>
                                    </div>
                                </div>
                                <button type="submit" {{ __('Login') }} class="btn btn-m btn-full mb-3 rounded-xs font-16 shadow-s bg-magenta-dark">
                                 Inloggen   </button>
                                <a href="#"
                                    class="btn btn-icon text-left btn-full btn-l font-600 font-13 bg-dark color-white mt-2 rounded-s"><i
                                        class="fas fa-phone px-2"></i>Login met mobiel nummer</a>
                                <a href="{{ route('facebook-redirect') }}"
                                    class="btn mb-4 btn-icon text-left btn-full btn-l font-600 font-13 bg-facebook mt-4 rounded-s color-white"><i
                                        class="fab fa-facebook-f text-center "></i>Inloggen met facebook</a>

                        </div>
                    </div>
                </form>
                </div>
                <div class="card-overlay bg-black opacity-85"></div>
            </div>



        </div>

        <!-- Page content ends here-->

        <!-- Main Menu-->
        <div id="menu-main" class="menu menu-box-left rounded-0" data-menu-load="menu-main.html" data-menu-width="280"
            data-menu-active="nav-pages"></div>

        <!-- Share Menu-->
        <div id="menu-share" class="menu menu-box-bottom rounded-m" data-menu-load="menu-share.html"
            data-menu-height="370"></div>

        <!-- Colors Menu-->
        <div id="menu-colors" class="menu menu-box-bottom rounded-m" data-menu-load="menu-colors.html"
            data-menu-height="480"></div>


    </div>
</body>
@endsection('content')
