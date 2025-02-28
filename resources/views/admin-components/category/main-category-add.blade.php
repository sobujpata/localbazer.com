<div class="all-Orders-Details">
    <div class="head-newProduct">
        <h1>Add a New Main Category</h1>
        <button type="button" class="black-70-button"><a href="{{ url('/main-category') }}">Main Category List</a></button>

    </div>

    <div class="addProduct">
        <div class="productHeader">
            <h2>Main Category information</h2>
            
        </div>
        <form id="save-form">
            
            <div class="input-grid">
                <span>
                    <p>Main Category Name*</p>
                    <input id="categoryName" class="categoryName" type="text" placeholder="Main Category Name">
                </span>
           
                <span>
                    <p>Main Category Image</p>
                    <img class="" id="newImg" src="{{asset('images/default.jpg')}}" style="width:50px;"/>
                    
                    <input oninput="newImg.src=window.URL.createObjectURL(this.files[0])" type="file" name="img1" id="img1" style="white-space: 80%; float:right;">
                </span>
                
            </div>
        </form>
        {{-- <button type="reset" id="main-category-form" class="black-70-button">Clear Form</button> --}}
        <button onclick="Save()" class="black-button" >Publish Main Category</button>


       

    </div>
</div>

<script>
    async function Save() {
    let categoryName = document.getElementById('categoryName').value;
    let img1 = document.getElementById('img1').files[0];
    
    
    if (!categoryName) return errorToast("main-category categoryName is Required!");
    

    
    let formData = new FormData();
    
    formData.append('categoryName', categoryName);
    formData.append('img1', img1);
    

    // console.log([...formData.entries()]); // Debugging formData

    try {
        showLoader();
        let res = await axios.post("/create-main-category", formData, {
            headers: { 'Content-Type': 'multipart/form-data' },
        });
        // console.log(res)
        hideLoader();
        if (res.status === 200) {
            successToast('Main Category Created Successfully!');
            document.getElementById("save-form").reset();
            window.location.href="/main-category"
        } else {
            errorToast("Failed to Create main-category");
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