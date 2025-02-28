<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>It Solution One of The Best Solution</title>
    <!--- favicon-->
    <link rel="shortcut icon" href="{{ asset('images/logo/it-logo.jpg') }}" type="image/x-icon">
    <link href="{{asset('css/dashboard.css')}}" rel="stylesheet" />
    {{-- <script src="{{asset('js/dashboard.js')}}"></script> --}}
    <link href="{{asset('css/toastify.min.css')}}" rel="stylesheet" />
    <link href="{{asset('css/jquery.dataTables.min.css')}}" rel="stylesheet" />
    <link href="{{asset('css/progress.css')}}" rel="stylesheet" />
    <link href="{{asset('css/modal.css')}}" rel="stylesheet" />
    {{-- <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet" /> --}}

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <script src="{{asset('js/jquery-3.7.0.min.js')}}"></script>
    <script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
    {{-- <script src="{{asset('js/bootstrap.bundle.js')}}"></script> --}}


    <script src="{{asset('js/toastify-js.js')}}"></script>
    <script src="{{asset('js/axios.min.js')}}"></script>
    <script src="{{asset('js/config.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/js/all.min.js"></script>

    
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    <style>
        .d-none{
            display:none;
        }
        a{
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div id="loader" class="LoadingOverlay d-none">
        <div class="Line-Progress">
            <div class="indeterminate"></div>
        </div>
    </div>
    <div class="container">
        @include('layouts.partials.nav2')
        <div class="main">
            @include('layouts.partials.top-bar')
            @yield('content')
        </div>
    </div>
    
    
    @stack('custom-scripts')
    <script>
        // add hovered class to selected list item =================================================
        let list = document.querySelectorAll(".navigation li");

        function activeLink() {
        list.forEach((item) => {
            item.classList.remove("hovered");
        });
        this.classList.add("hovered");
        }

        list.forEach((item) => item.addEventListener("mouseover", activeLink));

        // Menu Toggle ================================================
        let toggle = document.querySelector(".toggle");
        let navigation = document.querySelector(".navigation");
        let main = document.querySelector(".main");

        toggle.onclick = function () {
        navigation.classList.toggle("active");
        main.classList.toggle("active");
        };



        // ===================================================================


        const listItems = document.querySelectorAll(".sidebar-list li");

        listItems.forEach((item) => {
        item.addEventListener("click", () => {
            let isActive = item.classList.contains("active");

            listItems.forEach((el) => {
            el.classList.remove("active");
            });

            if (isActive) item.classList.remove("active");
            else item.classList.add("active");
        });
        });

        const toggleSidebar = document.querySelector(".toggle-sidebar");
        const logo = document.querySelector(".logo-box");
        const sidebar = document.querySelector(".sidebar");

        toggleSidebar.addEventListener("click", () => {
        sidebar.classList.toggle("close");
        });

        logo.addEventListener("click", () => {
        sidebar.classList.toggle("close");
        });

    </script>

</body>

</html>
