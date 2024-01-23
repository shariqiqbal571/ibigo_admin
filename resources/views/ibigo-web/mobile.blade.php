@extends('../layouts/main_web_layout')
@section('title', 'Ibigo | Mobile Login')
@section('content')

            <div class="page-content pt-5 pb-5">

                <div  class="card card-1" style="background-image:url({{asset('ibigo-web/images/11.jpg')}}); height: 800px;">
                    <div class="card-center">

                        <div class=" text-center pt-5">
                            <p class="font-600  mb-1 font-18 color-magenta-dark pt-5">Let's Get Started</p>
                            <h1 class="font-700 color-white">Mobile Sign In</h1>
                        </div>
                        <div class=" text-center">
                            <div class="  information">
                                <i class="fas fa-check" style="color: green ;"></i>
                                <span class="color-white font-14">Ontvang aanbevelingen van vrienden, spots, events en Ibigo</span>
                            </div>
                        </div>
                        <div class=" text-center">
                            <div class="  information">
                                <i class="fas fa-check  " style="color: green ;"></i>
                                <span class="color-white font-14">Plan uitjes en events met jouw vrienden via de Ibigo planner.</span>
                            </div>
                        </div>
                        <div class=" text-center">
                            <div class="  information">
                                <i class="fas fa-check  "  style="color: green ;"></i>
                                <span class="color-white font-14">Plan uitjes en events met jouw vrienden via de Ibigo planner.</span>
                            </div>
                        </div>
                        <div class=" text-center">
                            <div class="  information">
                                <i class="fas fa-check  "  style="color: green ;"></i>
                                <span class="color-white font-15 ">
                                    Maak connecties met andere gebruikers, spots en events</span>
                            </div>
                        </div>
                        <div class=" text-center">
                            <div class="  information">
                                <i class="fas fa-check"  style="color: green ;" ></i>
                                <span class="color-white font-14 pb-4">
                                    Vind de leukste en hipste spots & events afgestemd op jouw<br> persoonlijke
                                    voorkeuren. </span>
                            </div>
                        </div>
                        <div class="container">
                        <div class="content px-4">
                            <div class="input-style input-light has-icon input-style-1 input-required">
                                <i class="input-icon fas fa-phone"></i>
                                <span>Mobile number</span>
                                <em>(required)</em>
                                <input type="text" placeholder="10 123 4567">
                            </div>
                            <div class="input-style input-light has-icon input-style-1 input-required">
                                <i class="input-icon fas fa-lock"></i>
                                <span>OTP nummer</span>
                                <em>(required)</em>
                                <input type="password" placeholder="OTP nummer">
                            </div>
                            <div class="row pt-3 mb-3">
                                <div class="col-6 text-left font-11">
                                    <a class="color-white opacity-50" href="page-forgot-2.html">Wachtwoord vergeten?</a>
                                </div>
                                <div class="col-6 text-right font-11">
                                    <a class="color-white opacity-50" href="page-signup-2.html">Creëer een nieuw
                                        account</a>
                                </div>
                            </div>
                            <a href="#" class="btn btn-m btn-full mb-3 rounded-xs font-16 shadow-s bg-magenta-dark"> Inloggen</a>
                            <a href="#"
                                class="btn btn-icon text-left btn-full btn-l font-600 font-13 bg-dark color-white mt-2 rounded-s"><i
                                    class="fas fa-phone px-2"></i>Login met gebruikersnaam en Wachtwoord</a>
                            <a href="#"
                                class="btn mb-4 btn-icon text-left btn-full btn-l font-600 font-13 bg-facebook mt-4 rounded-s color-white"><i
                                    class="fab fa-facebook-f text-center "></i>Inloggen met facebook</a>


                        </div>
                    </div>
                    </div>
                    <div class="card-overlay bg-black opacity-85"></div>
                </div>



            </div>



        </div>
   @endsection
