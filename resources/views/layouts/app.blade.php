<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Local Bazer One of The Best Solution</title>

    <!--- favicon-->
    <link rel="shortcut icon" href="{{ asset('images/icons/apple.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

    <!--- custom css link-->
    <link href="{{ asset('css/toastify.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/style-prefix.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('css/progress.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}" />

    <link href="{{asset('css/jquery.dataTables.min.css')}}" rel="stylesheet" />
    <script src="{{asset('js/jquery-3.7.0.min.js')}}"></script>
    <script src="{{asset('js/jquery.dataTables.min.js')}}"></script>


    <script src="{{asset('js/toastify-js.js')}}"></script>
    <script src="{{asset('js/config.js')}}"></script>
    <script src="{{asset('js/axios.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.bundle.js')}}"></script>
    <!--- google font link-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- <link rel="stylesheet" href="chat.css"> -->
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script> --}}
 
      
    <style>
        .d-none {
            display: none;
        }

        a {
            text-decoration: none;
        }

        .product-grid {
        gap: 15px !important;
    }
    /* a{
        color:black !important;
    } */
    .sidebar-menu-category-list{
        padding: 0px !important;
    }
    </style>
</head>

<body>
    <!-- chat div -->
    <div class="overlay" data-overlay></div>
    <div id="loader" class="LoadingOverlay d-none">
        <div class="Line-Progress">
            <div class="indeterminate"></div>
        </div>
    </div>
    
    @include('layouts.partials.nav')

    <main>
        @yield('content')
    </main>
    @include('layouts.partials.footer')
    <script src="{{asset('js/script.js')}}"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('custom-scripts')

    <!--- custom js link-->
    <!-- <script src="chat.js"></script> -->
    <script>
        
        async function AddToCart() {
            

            const p_id = document.getElementById('p_id').value;
            const p_color = document.getElementById('p_color').value;
            const p_qty = parseInt(document.getElementById('p_qty').value, 10);
    
            if (!p_color) {
                return alert("Please select a color.");
            }
            if (!p_qty || p_qty <= 0) {
                return alert("Quantity must be greater than 0.");
            }
    
            try {
                showLoader();
                const response = await axios.post("/CreateCartList", { product_id: p_id, color: p_color, qty: p_qty });
                hideLoader();
    
                if (response.status === 201 && response.data.status === 'success') {
                    successToast(response.data.message);
                    // await CountCart();
                } else {
                    errorToast("Failed to add to cart. Please login.");
                    window.location.href = "/login";
                }
            } catch (error) {
                hideLoader();
                if (error.response?.status === 401) {
                    sessionStorage.setItem("last_location", window.location.href);
                    window.location.href = "/login";
                } else {
                    errorToast("An error occurred. Please try again.");
                }
            }
        }
    
    
    
    
        async function AddToWishList() {
            try{
                $(".preloader").delay(90).fadeIn(100).removeClass('loaded');
                let res = await axios.get("/CreateWishList/"+id);
                $(".preloader").delay(90).fadeOut(100).addClass('loaded');
                if(res.status===200){
                    alert("Request Successful")
                }
            }catch (e) {
                if(e.response.status===401){
                    sessionStorage.setItem("last_location",window.location.href)
                    window.location.href="/login"
                }
            }
        }
        
       
    </script>
    
    
</body>

</html>
