<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The it Solution Bd</title>

    <!--- favicon-->
    <link rel="shortcut icon" href="{{ asset('images/icons/apple.png') }}" type="image/x-icon">

    <!--- custom css link-->
    <link rel="stylesheet" href="{{ asset('css/style-prefix.css') }}">

    <!--- google font link-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- <link rel="stylesheet" href="chat.css"> -->

</head>

<body>
    <!-- chat div -->
    <div class="overlay" data-overlay></div>
    @include('components.home.model')
    @include('components.home.notification-toast')
    @include('layouts.partials.nav')

    <main>
        @yield('content')
    </main>
    @include('layouts.partials.footer')
    <!--- custom js link-->
    <script src="{{asset('js/script.js')}}"></script>
    <!-- <script src="chat.js"></script> -->

    <!--- ionicon link-->
    <script type="module" src="{{ asset('js/ionicons.js') }}"></script>
    <script nomodule src="{{ asset('js/ionicons2.js') }}"></script>

</body>

</html>
