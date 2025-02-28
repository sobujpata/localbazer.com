<!--============  Cards  ===========-->
<div class="productCardBox">

    <div class="card">
        <div>
            <div class="numbers">Add Customer</div>
        </div>

        <div class="iconBx">
            <ion-icon name="person-add-outline"></ion-icon>
        </div>
    </div>

    <div class="card">
        <div>
            <div class="numbers"><span id="customer"></span></div>
            <div class="cardName">Total customer</div>
        </div>

        <div class="iconBx">
            <ion-icon name="people-outline"></ion-icon>
        </div>
    </div>
</div>
<script>
    getSummar();
    async function getSummar() {
        showLoader();
        let res=await axios.get("/summary");
        hideLoader();
        // console.log(res);
        //General Info
        document.getElementById('customer').innerText=res.data['customer']
       
    }
</script>