<style>
    a {
        text-decoration: none;
    }

    .remove {
        background-color: rgb(236, 41, 100);
        color: white;
        padding: 5px;
        border-radius: 5px;
        width: 70px;
    }

    .remove:hover {
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
        <div class="row align-items-center px-4">
            <div class="col-md-2">
                <h2 class="title">
                    <span><a href="{{ url('/') }}" class="text-dark bolder">Home</a></span> / <span><a href="{{ url('/order') }}" class="text-dark border-2">Order List</a></span>
                </h2>
            </div>
            <div class="col-md-8">
                <div class="page-title">
                    <h1 class="text-decoration-underline border-3">Invoice List</h1>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8 col-sm-12 " id="orderProduct">

        </div>
    </div>
</div>
<hr style="">

<script>
async function orderList() {
    try {
        showLoader(); // Display loader
        const res = await axios.get('/invoice-customer-list');
        hideLoader(); // Hide loader

        // console.log(res)
        const orderItems = res.data['data'];
        const orderContainer = $("#byList");
        // Clear existing order items
        orderContainer.empty();

        // Handle empty order
        if (orderItems.length === 0) {
            orderContainer.append('<tr><td colspan="5">Your order is empty. Start shopping now!</td></tr>');
            $("#total").text(0);
            return;
        }

        // Render order items
        orderItems.forEach(item => {
            orderContainer.append(renderorderRow(item));
        });

        $('.editBtn').on('click', async function () {
           let id= $(this).data('id');
           let total= $(this).data('total');
           await InvoiceProductsPage(id,total)
           $("#staticBackdrop").modal('show');


    })

        

    } catch (error) {
        hideLoader();
        console.error(error);
        errorToast("Failed to fetch order items. Please try again.");
    }
}

// Helper to render a order row
function renderorderRow(item) {
    let div = `
            <div class="card m-2">
                <div class="card-body ">
                  <div class="row px-2">
                            <div class="col-md-5 mb-3">
                                
                                <div class="row">
                                    <div class="col-6"><h5 class="">Invoice</h5></div>
                                    <div class="col-1">:</div>
                                    <div class="col-5"><span style="float: right;">#INV${item.id}</span></div>

                                    <div class="col-6">Subtotal</div>
                                    <div class="col-1">:</div>
                                    <div class="col-5"><span style="float: right;">${item.total}</span></div>

                                    <div class="col-6">Shipping Charge</div>
                                    <div class="col-1">:</div>
                                    <div class="col-5"><span style="float: right;">${item.shipping_charge}</span></div>
                                    <hr>
                                    <div class="col-6"><strong>Payable</strong></div>
                                    <div class="col-1">:</div>
                                    <div class="col-5"><strong style="float: right;">${item.payable}</strong></div>
                                    
                                    
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="row justify-content-center">
                                    <div class="col-md-9">
                                        <span class="text-sm"><strong>Shipping Address: </strong>${item.ship_details}</span>
                                        <div class="col-12 text-center btn btn-outline-info btn-sm mt-3 rounded-2">Order Status: ${item.delivery_status}</div>
                                    </div>
                                    <div class="col-md-3 mt-4 text-center ">
                                        
                                        <!-- Button trigger modal -->
                                        <button data-id="${item['id']}" data-total="${item['payable']}" class="btn editBtn btn-sm btn-outline-primary rounded-2">Details</button>
                                        
                                    </div>
                                </div>
                                
                            </div>
                            

                        </div>
                    </div>
                </div>
        `;

        // Append the constructed HTML to the /products/${item['id']}topRate2 element
        document.getElementById("orderProduct").innerHTML += div;

    
}

// Helper to calculate and display total price
function calculateTotal(orderItems) {
    const total = orderItems.reduce((sum, item) => sum + parseFloat(item.price), 0);
    $("#total").text(total.toFixed(2)); // Display total with 2 decimal points
}

// Handle product removal
async function confirmRemoval(productId) {
    if (confirm("Are you sure you want to remove this item?")) {
        await removeorderItem(productId);
    }
}



// Initial call to load the order
orderList();

</script>
