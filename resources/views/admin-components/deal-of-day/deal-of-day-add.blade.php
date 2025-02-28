<div class="all-Orders-Details">
    <div class="head-newProduct">
        <h1>Add a New Brand</h1>
        <button type="button" class="black-70-button"><a href="{{ url('/brand-list') }}">Back Brand List</a></button>

    </div>

    <div class="addProduct">
        <div class="productHeader">
            <h2>Brand information</h2>
            
        </div>
        <form id="save-form">
            
            <div class="input-grid">
                <span>
                    <p>deals Name*</p>
                    <select id="dealsProductId" class="dealsProductId" style="width: 100%; height: 35px;">
                        <option value="" selected>Select product</option>
                        @foreach ($products as $product)
                        <option value="{{ $product->id }}">{{ $product->title }}</option>
                        @endforeach
                    </select>
                </span>
                <span>
                    <p>Sold Qty*</p>
                    <input id="soldQty" class="soldQty" type="number" value="" placeholder="Sold Qy">
                </span>
                <span>
                    <p>Offer Up To*</p>
                    <input id="OfferUpTo" class="OfferUpTo" type="datetime-local" value="">
                </span>
           
                <span>
                    <p>Brand Image</p>
                    <img class="" id="newImg" src="{{asset('images/default.jpg')}}" style="width:50px;"/>
                    
                    <input oninput="newImg.src=window.URL.createObjectURL(this.files[0])" type="file" name="img1" id="img1" style="white-space: 80%; float:right;">
                </span>
                
            </div>
        </form>
            {{-- <button type="reset" id="sub-category-form" class="black-70-button">Clear Form</button> --}}
            <button onclick="Save()" class="black-button" >Publish Brand</button>


       

    </div>
</div>

<script>
    async function Save() {
    let dealsProductId = document.getElementById('dealsProductId').value;
    let soldQty = document.getElementById('soldQty').value;
    let  OfferUpTo= document.getElementById('OfferUpTo').value;
    let img1 = document.getElementById('img1').files[0];
    
    
    if (!dealsProductId) return errorToast("Product is Required!");
    if (!soldQty) return errorToast("Sold is Required!");
    if (!OfferUpTo) return errorToast("Offer up to date is Required!");
    

    
    let formData = new FormData();
    
    formData.append('dealsProductId', dealsProductId);
    formData.append('soldQty', soldQty);
    formData.append('OfferUpTo', OfferUpTo);
    formData.append('img1', img1);
    

    // console.log([...formData.entries()]); // Debugging formData

    try {
        showLoader();
        let res = await axios.post("/create-deal-of-the-day", formData, {
            headers: { 'Content-Type': 'multipart/form-data' },
        });
        // console.log(res)
        hideLoader();
        if (res.status === 200) {
            successToast('Deal of the day Created Successfully!');
            document.getElementById("save-form").reset();
            window.location.href="/deal-of-the-day-admin"
        } else {
            errorToast("Failed to Create Deal of the day");
        }
    } catch (error) {
        hideLoader();
        if (error.response && error.response.data.message) {
            errorToast("Server Error: " + error.response.data.message);
        } else {
            errorToast("An Error Occurred: " + error.message);
        }
    }
}

</script>