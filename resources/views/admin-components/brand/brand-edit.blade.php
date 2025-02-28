<div class="all-Orders-Details">
    <div class="head-newProduct">
        <h1>Edit Brand</h1>
        <button type="button" class="black-70-button"><a href="{{ url('/brand-list') }}">Brand List</a></button>

    </div>

    <div class="addProduct">
        <div class="productHeader">
            <h2>Brand information</h2>
            
        </div>
        <form id="save-form">
            
            <div class="input-grid">
                <input class="d-none" id="brandId" class="brandId" type="text" value="{{ $brand->id }}">

                <span>
                    <p>Brand Name*</p>
                    <input id="brandName" class="brandName" type="text" value="{{ $brand->brandName }}">
                </span>
                
           
                <span>
                    <p>Brand Image</p>
                    <img class="" id="newImg" src="{{asset($brand->brandImg)}}" style="width:50px;"/>
                    
                    <input oninput="newImg.src=window.URL.createObjectURL(this.files[0])" type="file" name="img1" id="img1" style="white-space: 80%; float:right;">
                </span>
                
            </div>
        </form>
        <button onclick="Update()" class="black-button" >Update Brand</button>


       

    </div>
</div>

<script>
   
    async function Update() {
    let brandId = document.getElementById('brandId').value;
    let brandName = document.getElementById('brandName').value;
    let img1 = document.getElementById('img1').files[0];
    
    
    if (!brandName) return errorToast("sub-category brandName is Required!");
    

    
    let formData = new FormData();
    
    formData.append('id', brandId);
    formData.append('brandName', brandName);
    formData.append('img1', img1);
    

    console.log([...formData.entries()]); // Debugging formData

    try {
        showLoader();
        let res = await axios.post("/update-brand", formData, {
            headers: { 'Content-Type': 'multipart/form-data' },
        });
        // console.log(res)
        hideLoader();
        if (res.status === 200) {
            successToast('Brand Updated Successfully!');
            window.location.href = '/brand-list';
        } else {
            errorToast("Failed to Update Brand");
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