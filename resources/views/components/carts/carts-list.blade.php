<style>
    a {
        text-decoration: none;
    }

    .remove-btn {
        /* background-color: rgb(236, 41, 100); */
        color: white;
        padding: 5px;
        border-radius: 5px;
        width: 70px;
    }

    .remove-btn:hover {
        background-color: #f7f0ef;
        color: rgb(231, 12, 12);
    }

    .check-out-btn {
        background-color: blueviolet;
        color: white;
        padding: 5px;
        border-radius: 5px;
    }

    .check-out-btn:hover {
        background-color: #7cc2eb;
        color: black;
    }

    table {
        width: 100%;
        text-align: center;
    }

    .page-title {
        text-align: center;
    }

    hr {
        margin-bottom: 10px;
        margin-top: 10px
    }

    thead {
        background-color: #303233;
        color: white;
    }

    th {
        padding: 10px;
    }

    tr:hover {
        background-color: #b4b4b4;
    }
    .text-decoration-underline{
        text-decoration:underline;
    }
    @media only screen and (max-width: 600px) {
        th, td {
            font-size:12px;
        }
        .container-table{
            padding:0px;
        }

    }
</style>
<!-- START SECTION BREADCRUMB -->
<div class="breadcrumb_section bg_gray page-title-mini">
    <div class="container">
        <div class="row align-items-center">
            
            <div class="col-md-2">
                <h2 class="title">
                    <span><a class="text-dark" href="{{ url('/') }}">Home</a></span> / <span><a class="text-dark" href="{{ url('/cart') }}">Cart List</a></span>
                </h2>
                
            </div>
            <div class="col-md-8">
                <div class="page-title">
                    <h1 class="text-decoration-underline">Cart List</h1>
                </div>
            </div>
        </div>
    </div><!-- END CONTAINER-->
</div>
<hr>
<div class="mt-5">
    <div class="container my-5 container-table">
        <div class="row">
            <div class="col-md-8">
                <div class="card" id="cartProduct">
                    
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body m-2 rounded-2" style="background-color:#f0f0f0">
                        <p>Order Summary:</p>
                    <p><span>Total:</span><span style="float:right;" id="total"></span></p>
                        <a href="{{ url('/payment-form') }}" class="btn btn-success w-100">Checkout</a>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    <hr style="">
</div>

<script>
async function CartList() {
    try {
        showLoader(); // Show loader
        const res = await axios.get('/CartList');
        hideLoader(); // Hide loader

        document.getElementById('total').innerHTML = res.data.totalPrice;

        const cartItems = res.data['data'];
        const cartContainer = $("#cartProduct"); 
        cartContainer.empty(); // Clear previous items

        if (cartItems.length === 0) {
            cartContainer.append('<tr><td colspan="5"><a href="/">Your cart is empty. Start shopping now!</a></td></tr>');
            $("#total").text("0.00");
            return;
        }

        cartItems.forEach(item => {
            cartContainer.append(renderCartRow(item));
        });


        $(document).off('click', '.increment').on('click', '.increment', function () {
            const input = $(this).siblings('input');
            updateQuantity(input, 1);
        });

        $(document).off('click', '.decrement').on('click', '.decrement', function () {
            const input = $(this).siblings('input');
            updateQuantity(input, -1);
        });


    } catch (error) {
        hideLoader();
        console.error(error);
        errorToast("Failed to fetch cart items. Please try again.");
    }

        $(document).off('click', '.deleteBtn').on('click', '.deleteBtn', function () {
        const productId = $(this).data('id');

        Swal.fire({
            // title: "Are you sure to remove this item?",
            text: "Are you sure to remove this item?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, remove it!"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `/DeleteCartList?id=${productId}`;
            }
        });
});

}

// Render cart row dynamically
function renderCartRow(item) {
    return `
        <div class="card-body m-2 rounded-2" style="background-color:#f0f0f0">
            <div class="row">
                <div class="col-md-2 col-3">
                    <img src="${item.product.image}" alt="" style="width: 65px; border-radius:6px;">
                </div>
                <div class="col-md-10 col-9">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="row">
                                <div class="col-sm-8">
                                    <h5 style="float:left;">${item.product.title}</h5>
                                </div>
                                <div class="col-sm-4">
                                    <strong id="basePrice" data-price="${item.price}">BDT ${item.price}</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="row">
                                <div class="col-9">
                                    <button class="decrement btn btn-secondary btn-sm p-2">-</button>
                                    <input type="text" name="quantity" value="${item.qty}" maxlength="2" max="10" size="1" 
                                    class="quantity-input btn-sm btn p-2" style="width:40px !important;" 
                                    data-id="${item.product_id}" readonly />
                                    <button class="increment btn btn-secondary btn-sm p-2">+</button>
                                </div>
                                <div class="col-3">
                                    <button class="btn deleteBtn" data-id="${item.product_id}"><i class="fa fa-trash text-danger"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    `;
}

async function updateQuantity(input, change) {
    let currentQty = parseInt(input.val(), 10);
    let newQty = currentQty + change;
    if (newQty < 1 || newQty > 10) return;

    input.val(newQty);

    try {
        const productId = input.data('id');
        const res = await axios.post(`/UpdateCartQuantity`, {
            product_id: productId,
            quantity: newQty
        });

        if (res.data['status'] === 'success') {
            CartList();
        } else {
            errorToast("Failed to update quantity.");
            input.val(currentQty); // Reset input value if update fails
        }
    } catch (error) {
        console.error("Failed to update quantity:", error);
        input.val(currentQty); // Reset input if request fails
    }
}


// Initial call
CartList();

</script>