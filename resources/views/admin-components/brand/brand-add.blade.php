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
                    <p>Brand Name*</p>
                    <input id="brandName" class="brandName" type="text" placeholder="Brand Name">
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
    let brandName = document.getElementById('brandName').value;
    let img1 = document.getElementById('img1').files[0];
    
    
    if (!brandName) return errorToast("Brand is Required!");
    

    
    let formData = new FormData();
    
    formData.append('brandName', brandName);
    formData.append('img1', img1);
    

    // console.log([...formData.entries()]); // Debugging formData

    try {
        showLoader();
        let res = await axios.post("/create-brand", formData, {
            headers: { 'Content-Type': 'multipart/form-data' },
        });
        // console.log(res)
        hideLoader();
        if (res.status === 200) {
            successToast('Brand Created Successfully!');
            document.getElementById("save-form").reset();
            window.location.href="/brand-list"
        } else {
            errorToast("Failed to Create brand");
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