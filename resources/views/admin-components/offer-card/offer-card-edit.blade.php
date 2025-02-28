<div class="all-Orders-Details">
    <div class="head-newProduct">
        <h1>Edit Offer Card</h1>
        <button type="button" class="black-70-button"><a href="{{ url('/offer-card') }}">Offer card List</a></button>

    </div>

    <div class="addProduct">
        <div class="productHeader">
            <h2>Offer card information</h2>
            
        </div>
        <form id="save-form">
            
            <div class="input-grid">
                <input class="d-none" id="cardId" class="cardId" type="text" value="{{ $card->id }}">

                <span>
                    <p>Card title*</p>
                    <input id="cardTitle" class="cardTitle" type="text" value="{{ $card->title }}">
                </span>
                <span>
                    <p>Short Des*</p>
                    <input id="short_desUpdate" class="short_des" type="text" value="{{ $card->short_des }}">
                </span>
                <span>
                    <p>Discount*</p>
                    <input id="discountUpdate" class="discountUpdate" type="text" value="{{ $card->discount }}">
                </span>
           
                <span>
                    <p>Card Image</p>
                    <img class="" id="newImg" src="{{asset($card->image)}}" style="width:150px;"/>
                    
                    <input oninput="newImg.src=window.URL.createObjectURL(this.files[0])" type="file" name="img1" id="img1" style="white-space: 80%; float:right;">
                </span>
                
            </div>
        </form>
        <button onclick="Update()" class="black-button" >Update card</button>
    </div>
</div>

<script>
   
    async function Update() {
    let cardId = document.getElementById('cardId').value;
    let cardTitle = document.getElementById('cardTitle').value;
    let short_desUpdate = document.getElementById('short_desUpdate').value;
    let discountUpdate = document.getElementById('discountUpdate').value;
    let img1 = document.getElementById('img1').files[0];
    
    
    if (!cardTitle) return errorToast("offer-card Title is Required!");
    if (!short_desUpdate) return errorToast("Short Des Title is Required!");
    if (!discountUpdate) return errorToast("discount Title is Required!");
    

    
    let formData = new FormData();
    
    formData.append('id', cardId);
    formData.append('title', cardTitle);
    formData.append('short_des', short_desUpdate);
    formData.append('discount', discountUpdate);
    formData.append('image', img1);
    

    console.log([...formData.entries()]); // Debugging formData

    try {
        showLoader();
        let res = await axios.post("/update-offer-card", formData, {
            headers: { 'Content-Type': 'multipart/form-data' },
        });
        // console.log(res)
        hideLoader();
        if (res.status === 200) {
            successToast('Offer card Updated Successfully!');
            window.location.href = '/offer-card';
        } else {
            errorToast("Failed to Update offer-card");
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