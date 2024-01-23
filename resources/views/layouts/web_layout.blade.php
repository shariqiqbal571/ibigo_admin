<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/a.ico">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{asset('ibigo-web/styles/style.css')}}">
    <link rel="stylesheet" href="{{asset('ibigo-web/styles/bootstrap.css')}}">
    <link href="{{url('https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap')}}"
        rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('ibigo-web/fonts/css/fontawesome-all.min.css')}}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
    <link rel="manifest" href="_manifest.json" data-pwa-version="set_in_manifest_and_pwa_js">
</head>

@yield('content')

<script src="{{asset('ibigo-web/scripts/jquery.js')}}"></script>
<script src="{{asset('ibigo-web/scripts/bootstrap.min.js')}}"></script>
<script src="{{asset('ibigo-web/scripts/custom.js')}}"></script>



<script>
    $(document).ready(function() {
        $('.tbName').on('input change', function() {
            if($(this).val() == '') {
                $('#submit').prop('disabled', true);
            } else {
                $('#submit').prop('disabled', false);
            }
        });
    });
    </script>


</html>
