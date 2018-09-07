<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Event Tommorow') }}</title>
    <link href="{{ asset('css/about/about.css')}}" rel="stylesheet">
    <base href="{{asset('')}}">
    @include('layouts.link')

</head>
    <body id="top" data-spy="scroll" data-target=".navbar-collapse" data-offset="50">

     <!-- PRE LOADER -->
     <section class="preloader">
          <div class="spinner">
               <span class="spinner-rotate"></span>
               
          </div>
     </section>

     @include('layouts.header1')
     <div>
         @yield('content')    
     </div>
     @include('layouts.footer')

    
</body>
</html>
