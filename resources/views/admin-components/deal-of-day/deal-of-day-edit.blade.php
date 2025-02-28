<div class="all-Orders-Details">
    <div class="head-newProduct">
        <h1>Edit deals</h1>
        {{-- <button type="button" class="black-70-button"><a href="{{ url('/deals-list') }}">deals List</a></button> --}}

    </div>

    <div class="addProduct">
        <div class="productHeader">
            <h2>deals information</h2>
            
        </div>
        {{-- @dd($deals->id) --}}
        <form id="save-form">
            
            <div class="input-grid">
                <input class="d-none" id="dealsId" class="dealsId" type="text" value="{{ $deals->id }}">

                
                <span>
                    <p>deals Name*</p>
                    <select id="dealsProductId" class="dealsProductId" style="width: 100%; height: 35px;">
                        @foreach ($products as $product)
                        <option value="{{ $product->id }}">{{ $product->title }}</option>
                        @endforeach
                    </select>
                </span>
                <span>
                    <p>Sold Qty*</p>
                    <input id="soldQty" class="soldQty" type="number" value="{{ $deals->sold }}">
                </span>
                <span>
                    <p>Offer Up To*</p>
                    <input id="OfferUpTo" class="OfferUpTo" type="datetime-local" value="{{ $deals->count_down }}">
                </span>
                
           
                <span>
                    <p>Deals Image</p>
                    <img class="" id="newImg" src="{{asset($deals->image_url)}}" style="width:50px;"/>
                    
                    <input oninput="newImg.src=window.URL.createObjectURL(this.files[0])" type="file" name="img1" id="img1" style="white-space: 80%; float:right;">
                </span>
                
            </div>
        </form>
        <button onclick="Update()" class="black-button" >Update deals</button>


       

    </div>
</div>

<script>
   
    async function Update() {
    let dealsId = document.getElementById('dealsId').value;
    let dealsProductId = document.getElementById('dealsProductId').value;
    let soldQty = document.getElementById('soldQty').value;
    let OfferUpTo = document.getElementById('OfferUpTo').value;
    let img1 = document.getElementById('img1').files[0];
    
    
    if (!dealsProductId) return errorToast("sub-category dealsProductId is Required!");
    if (!soldQty) return errorToast("sub-category soldQty is Required!");
    if (!OfferUpTo) return errorToast("sub-category OfferUpTo is Required!");
    

    
    let formData = new FormData();
    
    formData.append('id', dealsId);
    formData.append('dealsProductId', dealsProductId);
    formData.append('soldQty', soldQty);
    formData.append('OfferUpTo', OfferUpTo);
    formData.append('img1', img1);
    

    console.log([...formData.entries()]); // Debugging formData

    try {
        showLoader();
        let res = await axios.post("/update-deal-of-the-day", formData, {
            headers: { 'Content-Type': 'multipart/form-data' },
        });
        // console.log(res)
        hideLoader();
        if (res.status === 200) {
            successToast('Deals Updated Successfully!');
            window.location.href = '/deal-of-the-day-admin';
        } else {
            errorToast("Failed to Update deals");
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