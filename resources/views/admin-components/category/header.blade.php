<!--============  Cards  ===========-->
<div class="productCardBox">

    <div class="card">
        <a href="{{url('/dashboard/product-add')}}">
            <div>
                <div class="numbers">Add Product</div>
            </div>

            <div class="iconBx">
                <ion-icon name="add-circle-outline"></ion-icon>
            </div>
        </a>
    </div>

    <div class="card">
        <div>
            <div class="numbers" id="productCount"></div>
            <div class="cardName">Total Products</div>
        </div>

        <div class="iconBx">
            <ion-icon name="snow-outline"></ion-icon>
        </div>
    </div>
</div>

<script>
    ProductCount();

    async function ProductCount(){
        let res = await axios.get('/count-product');

        // console.log(res.data['productCount']);
        document.getElementById('productCount').innerText=res.data['productCount']
    }
</script>