
@extends('../layouts/web_layout')
@section('title', 'Ibigo | Forget Password')
@section('content')


<body>

<div id="preloader"><div class="spinner-border color-highlight" role="status"></div></div>

<div id="page">

    @include('include.footer-bar')

    <div class="page-content">

        <div data-card-height="cover" class="card mb-0" style="background-image:url({{asset('ibigo-web/images/11.jpg')}})">
            <div class="card-center">
                <div class="text-center">
                    <h1 class="font-40 color-white">Forgot Password</h1>
                    <p class="boxed-text-xl color-white opacity-50 pt-3 font-14">
                        Forgot Password Send password reset link to email
                    </p>
                </div>

                <form method="POST" action="{{route('password.email')}}">
                    @csrf

                <div class="container">
                <div class="content px-4">
                    <div class="input-style input-light has-icon input-style-1 input-required">
                        <i class="input-icon fas fa-envelope"></i>
                        <span>Email</span>
                        <em>(required)</em>
                        <input class="login-input @error('password') is-invalid @enderror" type="email" name="email" placeholder="Email*">

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                    </div>
                    <div class="col-6 text-left font-11">
                        <a class="color-white opacity-50" href="{{ route('login') }}">Back to login?</a>
                    </div>
                    <button type="submit" class="btn btn-m btn-full mb-3 rounded-xs text-uppercase font-600 shadow-s bg-magenta-dark mt-4"> Send Reset Password </button>
                </div>
                </div>
            </form>

            </div>
            <div class="card-overlay bg-black opacity-85"></div>
        </div>

    </div>
    <!-- Page content ends here-->

    <!-- Main Menu-->
    <div id="menu-main" class="menu menu-box-left rounded-0" data-menu-load="menu-main.html" data-menu-width="280" data-menu-active="nav-pages"></div>

    <!-- Share Menu-->
    <div id="menu-share" class="menu menu-box-bottom rounded-m" data-menu-load="menu-share.html" data-menu-height="370"></div>

    <!-- Colors Menu-->
    <div id="menu-colors" class="menu menu-box-bottom rounded-m" data-menu-load="menu-colors.html" data-menu-height="480"></div>


</div>

</body>

@endsection













