<!--==================== Order List =====================-->

<div class="all-Orders-Details">
    <div class="recentOrders" id="invoice">
        <style>
            table {
                border-collapse: collapse;
                width: 100%;
                text-align:center;
                }

                th, td {
                text-align: left;
                padding: 8px;
                }

                tr:nth-child(even){background-color: #f2f2f2}

                th {
                background-color: #04AA6D;
                color: white;
                }
            </style>
        <div class="">
            <h2 style="text-align: center;">Invoice Products</h2>
            <p style="margin-bottom:20px">Invoice No: #INV{{ $invoice->id }}</p>
        </div>
        <hr style="color:black; height:0px">
        <table id="customers">
                <tr>
                    <td>No.</td>
                    <td>Product Name</td>
                    <td>Rate</td>
                    <td>Quantity</td>
                    <td align="center">Price</td>
                </tr>

                @foreach ($InvoiceProducts as $index => $item) 
                <tr>
                    <td>{{ $index + 1 }}</td> <!-- Adding 1 to index to start from 1 instead of 0 -->
                    <td>{{ $item->products->title }}</td>
                    <td>{{ $item->products->discount_price }}</td>
                    <td>{{ $item->qty }}</td>
                    <td>{{ $item->sale_price }}</td>
                </tr>
                @endforeach
                <tr>
                    <td></td>
                    <td></td>
                    <td colspan="2">
                        <strong>Total Payable :</strong>
                    </td>
                    <td><strong>{{ $invoice->total }}</strong></td>
                </tr>
        </table>
    </div>
    <button onclick="PrintPage()" class="btn btn-black" style="padding: 7px; width: 100px; border-radius: 6px;">Print Invoice</button>
    <button class="btn btn-white" style="padding: 7px; width: 100px; border-radius: 6px;"><a href="{{ url('/orders') }}"><<-Back</a> </button>
    

</div>

    

<script>
    function PrintPage() {
        let printContents = document.getElementById('invoice').innerHTML;
        let originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        setTimeout(function() {
            location.reload();
        }, 1000);
    }
</script>
    