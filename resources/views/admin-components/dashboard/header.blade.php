<!--============  Cards  ===========-->
<div class="cardBox">
    <div class="card">
        <div>
            <div class="numbers" id="visitors"></div>
            <div class="cardName">Visitors</div>
        </div>

        <div class="iconBx">
            <ion-icon name="eye-outline"></ion-icon>
        </div>
    </div>

    <div class="card">
        <div>
            <div class="numbers" id="invoice"><span></span></div>
            <div class="cardName">Total Orders</div>
        </div>

        <div class="iconBx">
            <ion-icon name="cart-outline"></ion-icon>
        </div>
    </div>

    <div class="card">
        <div>
            <div class="numbers" id="total_today_invoice"></div>
            <div class="cardName">Today Orders</div>
        </div>

        <div class="iconBx">
            <ion-icon name="chatbubbles-outline"></ion-icon>
        </div>
    </div>

    <div class="card">
        <div>
            <div class="numbers" id="total"></div>
            <div class="cardName">Total Earning</div>
        </div>

        <div class="iconBx">
            <ion-icon name="cash-outline"></ion-icon>
        </div>
    </div>
</div>

<script>
    getVisitor();
    async function getVisitor(){
       let resVisitor = await axios.get('/visitors');
        document.getElementById('visitors').innerText=resVisitor.data;
    }
    getSummar();
    async function getSummar() {
        showLoader();
        let res=await axios.get("/summary");
        hideLoader();
        console.log(res);
        //General Info
        // document.getElementById('category').innerText=res.data['category']
        // document.getElementById('customer').innerText=res.data['customer']
        let invoice =document.getElementById('invoice').innerText=res.data['invoice']
        console.log(invoice)
        //total order details
        document.getElementById('total').innerText=res.data['total']
        // document.getElementById('totalLastMont').innerText=res.data['total_last_month_earn']
        // document.getElementById('totalCurrentMonth').innerText=res.data['total_current_month_earn']
        // document.getElementById('totalLastWeek').innerText=res.data['total_last_week_earn']
        // document.getElementById('totalCurrentWeek').innerText=res.data['total_current_week_earn']
        // document.getElementById('totalPreviosDay').innerText=res.data['total_previous_day_earn']
        // document.getElementById('totalTodayDay').innerText=res.data['total_today_earn']
        document.getElementById('total_today_invoice').innerText=res.data['total_today_invoice']
        // document.getElementById('total_previos_invoice').innerText=res.data['total_previos_invoice']
    }
</script>