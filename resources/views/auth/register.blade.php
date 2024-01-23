@extends('../layouts/web_layout')
@section('title', 'Ibigo | Register')
@section('content')

<body>

    <div id="preloader">
        <div class="spinner-border color-highlight" role="status"></div>
    </div>

    <div id="page">

        @include('include.footer-bar')

        <div class="page-content pt-5 pb-5">

            <div data-card-height="cover" class="card card-1" style="background-image:url({{asset('ibigo-web/images/11.jpg')}});">
                <div class="card-center">
                    <div class="text-center">
                        <p class="font-600 color-magenta-dark mb-4 mt-4 font-19">Maak uw gratis account aan</p>
                        <h1 class="font-40 color-white">Sign Up</h1>
                        <p class="boxed-text-xl color-white opacity-50 pt-3 font-15">

                        </p>

                    </div>

                    <form action="{{ route('register') }}" method="POST">
                    @csrf

                    <div class="container">

                        <div class="content  px-4 ">
                            <div class="input-group mb-3 ">
                                <div class="input-style input-light has-icon input-style-1 input-required "
                                    style="width: 50%;">
                                    <i class="input-icon fa fa-user"></i>
                                    <span>First Name</span>
                                    <em>(required)</em>
                                    <input type="text" class="tbName" placeholder="First Name" class="@error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" autofocus>
                                    <p class="color-white">+31</p>

                                    @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                     @enderror

                                </div>

                                <div class="input-style input-light has-icon input-style-1 input-required px-3 "
                                    style="width: 50%;">
                                    <i class="input-icon fa fa-user"></i>
                                    <span>Last Name</span>
                                    <em>(required)</em>
                                    <input type="text" class="tbName" placeholder="Last Name" class="@error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name" autofocus >

                                    @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                     @enderror


                                </div>
                            </div>
                            <div class="input-style input-light has-icon input-style-1 input-required  mb-3 ">
                                <input type="text" class="tbName" placeholder="10 123 4567" class="@error('phone_number') is-invalid @enderror" name="phone_number" value="{{ old('phone_number') }}" required autocomplete="email" autofocus>

                                @error('phone_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                 @enderror

                            </div>
                            <div class="input-group">

                                <div class="input-style input-light has-icon d-flex birth-date" style="width: 50%;margin-bottom: 10px;border-bottom: solid 1px rgba(0, 0, 0, 0.08);">
                                    <i class="input-icon fas fa-calendar-check my-auto"></i>
                                    <!-- <span>Birth Date</span> -->
                                    <input type="date" placeholder="Birth Date" name="birth_date" id="date" class="@error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus  />
                                    @error('birth_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                 @enderror

                                </div>
                                <div class="input-style input-light has-icon input-style-1 input-required px-3"
                                    style="width: 50%;">
                                    <i class="input-icon fas fa-envelope"></i>
                                    <span>Email</span>
                                    <em>(required)</em>
                                    <input type="email" class="tbName" placeholder="Email" class="@error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                     @enderror


                                </div>
                            </div>
                            <div class="input-group">
                                <div class="input-style input-light has-icon input-style-1 input-required"
                                    style="width: 50%;">
                                    <i class="input-icon   fa fa-user"></i>
                                    <span>Password</span>
                                    <em>(required)</em>
                                    <input type="password" class="tbName" placeholder="Password" class="@error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="input-style input-light has-icon input-style-1 input-required px-3"
                                    style="width: 50%;">
                                    <i class="input-icon  fa fa-user"></i>
                                    <span>confirmed passowrd</span>
                                    <em>(required)</em>
                                    <input id="password-confirm" class="tbName" type="password" class="" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>
                            <div class=" pt-3 mb-3">

                                <div class=" font-11 ml-atuo">
                                    <a class="color-white opacity-50 mt-0 ml-auto" href="{{ route('login') }}">Heb je geen
                                        account?</a>
                                </div>
                            </div>
                            <div class="custom-control custom-switch mt-2">
                                <input type="checkbox" class="custom-control-input" id="customSwitch1">
                                <label class="custom-control-label font-15" for="customSwitch1">Bij aanmelding, ga je
                                    akkoord met "ibigo"s <a href="{{ route('login') }}">Algemene voorwaarden</a></label>
                            </div>
                            <div class="custom-control custom-switch mt-2 mb-4">
                                <input type="checkbox" class="custom-control-input" id="customSwitch2">
                                <label class="custom-control-label font-15" for="customSwitch2">Ik wil graag commerciele
                                    email ontvangen</label>
                            </div>

                            <button type="submit"  {{ __('Register') }}
                            id="submit"  disabled="disabled"
                                class="btn btn-m mb-4 btn-full  rounded-xs text-uppercase font-600 shadow-s bg-magenta-dark">
                               registregen </button>


                        </div>
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
    <div id="menu-share" class="menu menu-box-bottom rounded-m" data-menu-load="menu-share.html" data-menu-height="370">
    </div>

    <!-- Colors Menu-->
    <div id="menu-colors" class="menu menu-box-bottom rounded-m" data-menu-load="menu-colors.html"
        data-menu-height="480"></div>


    </div>



    </body>

    @endsection('content')


