<div class="all-Orders-Details">
    <div class="head-newProduct">
        <h1>Add a New Sub Category</h1>
        <button type="button" class="black-70-button"><a href="{{ url('/sub-category') }}">Sub Category List</a></button>

    </div>

    <div class="addProduct">
        <div class="productHeader">
            <h2>Sub Category information</h2>
            
        </div>
        <form id="save-form">
            
            <div class="input-grid">
                <span>
                    <p>Sub Category Name*</p>
                    <input id="categoryName" class="categoryName" type="text" placeholder="sub Category Name">
                </span>
                <span>
                    <p>Main Category Name*</p>
                    <select name="main_category_id" id="main_category_id" style="width: 100%; height: 35px;">
                        <option value="">Select Sub Category</option>
                    </select>
                </span>
           
                <span>
                    <p>Sub Category Image</p>
                    <img class="" id="newImg" src="{{asset('images/default.jpg')}}" style="width:50px;"/>
                    
                    <input oninput="newImg.src=window.URL.createObjectURL(this.files[0])" type="file" name="img1" id="img1" style="white-space: 80%; float:right;">
                </span>
                
            </div>
            {{-- <button type="reset" id="sub-category-form" class="black-70-button">Clear Form</button> --}}
        </form>
        <button onclick="Save()" class="black-button" >Publish Sub Category</button>


       

    </div>
</div>

<script>
    FillCategoryDropDown();

    async function FillCategoryDropDown(){
        // showLoader();
        let res = await axios.get("/list-main-category")
        // console.log(res);
        res.data.forEach(function (item,i) {
            let option=`<option value="${item['id']}">${item['categoryName']}</option>`
            $("#main_category_id").append(option);
        })
        

        hideLoader()
    }


    async function Save() {
    let categoryName = document.getElementById('categoryName').value;
    let main_category_id = document.getElementById('main_category_id').value;
    let img1 = document.getElementById('img1').files[0];
    
    
    if (!categoryName) return errorToast("sub-category categoryName is Required!");
    

    
    let formData = new FormData();
    
    formData.append('categoryName', categoryName);
    formData.append('main_category_id', main_category_id);
    formData.append('img1', img1);
    

    // console.log([...formData.entries()]); // Debugging formData

    try {
        showLoader();
        let res = await axios.post("/create-sub-category", formData, {
            headers: { 'Content-Type': 'multipart/form-data' },
        });
        // console.log(res)
        hideLoader();
        if (res.status === 200) {
            successToast('Sub Category Created Successfully!');
            document.getElementById("save-form").reset();
            window.location.href="/sub-category"
        } else {
            errorToast("Failed to Create Sub-category");
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