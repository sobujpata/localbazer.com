<div class="all-Orders-Details">
    <div class="head-newProduct">
        <h1>Add a new Product</h1>
        <button type="button" class="black-70-button" style="background-color: #c232af; "><a href="{{ url('/products-list') }}" style="color:white;">Product List</a></button>

    </div>

    <div class="addProduct">
        <div class="productHeader">
            <h2>Product information</h2>
            
        </div>
        <form id="save-form">
            
            <div class="input-grid">
                <span>
                    <p>Title*</p>
                    <input id="title" class="title" type="text" placeholder="Product title">
                </span>
                <span>
                    <p>Short Description*</p>
                    <input type="text" name="short_des" id="short_des" placeholder="Short Description">
                </span>
                <span>
                    <p>Price*</p>
                    <input type="number" placeholder="Product Price" name="price" id="price">
                </span>
                <span>
                    <p>Discounted Price*</p>
                    <input type="number" placeholder="Discount Price" name="discount_price" id="discount_price">
                </span>
                <span>
                    <p>Stock</p>
                    <input type="number" placeholder="Stock Product" name="stock" id="stock" >
                </span>
                <span>
                    <p>Remark*</p>
                    <select name="remarks" id="remarks" style="width: 100%; height: 35px;">
                        <option value="">Select Remarks</option>
                        <option value="popular">Popular</option>
                        <option value="new">New</option>
                        <option value="top">Top</option>
                        <option value="special">Special</option>
                        <option value="trending">Trending</option>
                        <option value="regular">Regular</option>
                    </select>
                </span>
                <span>
                    <p>Category*</p>
                    <select name="main_category_id" id="main_category_id" style="width: 100%; height: 35px;">
                        <option value="">Select Category</option>
                    </select>
                </span>
                <span>
                    <p>Sub Category</p>
                    <select name="category_id" id="category_id" style="width: 100%; height: 35px;">
                        <option value="">Select Sub Category</option>
                    </select>
                </span>
                <span>
                    <p>Brand Name *</p>
                    <select name="brand_id" id="brand_id" style="width: 100%; height: 35px;">
                        <option value="">Select Brand</option>
                    </select>
                </span>
                <span>
                    <p>Star Rate</p>
                    <input type="text" placeholder="Star Rate" name="star" id="star">
                </span>
                <span>
                    <p>Color</p>
                    <input type="text" placeholder="Color (Multiple Color Using comma ',')" name="color" id="color">
                </span>
                <span>
                    <p>Size</p>
                    <input type="text" placeholder="Size" name="size" id="size">
                </span>
            </div>
            <span class="bio">
                <p>Description*</p>
                <textarea id="description" placeholder="Describe Your Product..." name="bio"></textarea>
            </span>
            <div class="input-grid">
                <span>
                    <p>Image 1</p>
                    <img class="" id="newImg" src="{{asset('images/default.jpg')}}" style="width:50px;"/>
                    
                    <input oninput="newImg.src=window.URL.createObjectURL(this.files[0])" type="file" name="img1" id="img1" style="white-space: 80%; float:right;">
                </span>
                <span>
                    <p>Image 2</p>
                    <img class="" id="newImg2" src="{{asset('images/default.jpg')}}" style="width:50px;"/>
                    <input oninput="newImg2.src=window.URL.createObjectURL(this.files[0])" type="file" name="img2" id="img2">
                </span>
                <span>
                    <p>Image 3</p>
                    <img class="" id="newImg3" src="{{asset('images/default.jpg')}}" style="width:50px;"/>
                    <input oninput="newImg3.src=window.URL.createObjectURL(this.files[0])" type="file" name="img3" id="img3">
                </span>
                <span>
                    <p>Image 4</p>
                    <img class="" id="newImg4" src="{{asset('images/default.jpg')}}" style="width:50px;"/>
                    <input oninput="newImg4.src=window.URL.createObjectURL(this.files[0])" type="file" name="img4" id="img4">
                </span>
            </div>
        </form>
        {{-- <button type="reset" id="product-form" class="black-70-button">Clear Form</button> --}}
        <button onclick="Save()" class="black-button" >Publish Product</button>


       

    </div>
</div>

<script>
    FillCategoryDropDown();

    async function FillCategoryDropDown(){
        // showLoader();
        let res = await axios.get("/list-main-category")
        let resSubCategory = await axios.get("/list-sub-category")
        // console.log(res);
        res.data.forEach(function (item,i) {
            let option=`<option value="${item['id']}">${item['categoryName']}</option>`
            $("#main_category_id").append(option);
        })
        resSubCategory.data.forEach(function (item,i) {
            let option=`<option value="${item['id']}">${item['categoryName']}</option>`
            $("#category_id").append(option);
        })

        hideLoader()
    }
    FillBrandDropdown()
    async function FillBrandDropdown(){
        let res = await axios.get('/list-brand');

        res.data.forEach(function (item,i) {
            let option=`<option value="${item['id']}">${item['brandName']}</option>`
            $("#brand_id").append(option);
        })
    }

    async function Save() {
    let title = document.getElementById('title').value;
    let short_des = document.getElementById('short_des').value;
    let price = document.getElementById('price').value;
    let discount_price = document.getElementById('discount_price').value;
    let stock = document.getElementById('stock').value;
    let remarks = document.getElementById('remarks').value;
    let star = document.getElementById('star').value;
    let main_category_id = document.getElementById('main_category_id').value;
    let category_id = document.getElementById('category_id').value;
    let brand_id = document.getElementById('brand_id').value;
    let color = document.getElementById('color').value;
    let size = document.getElementById('size').value;
    let description = document.getElementById('description').value;
    let img1 = document.getElementById('img1').files[0];
    let img2 = document.getElementById('img2').files[0];
    let img3 = document.getElementById('img3').files[0];
    let img4 = document.getElementById('img4').files[0];
    
    if (!title) return errorToast("Product Title is Required!");
    if (!short_des) return errorToast("Product Short Description is Required!");
    if (!price) return errorToast("Product Price is Required!");
    if (!discount_price) return errorToast("Product Discount Price is Required!");
    if (!stock) return errorToast("Product Stock is Required!");
    if (!remarks) return errorToast("Product Remarks are Required!");
    if (!star) return errorToast("Product Star Rating is Required!");
    if (!main_category_id) return errorToast("Product Main Category is Required!");
    if (!category_id) return errorToast("Product Sub Category is Required!");
    if (!brand_id) return errorToast("Product Brand is Required!");
    if (!color) return errorToast("Product Color is Required!");
    if (!size) return errorToast("Product Size is Required!");
    if (!description) return errorToast("Product Description is Required!");

    
    let formData = new FormData();
    
    formData.append('title', title);
    formData.append('short_des', short_des);
    formData.append('price', price);
    formData.append('discount_price', discount_price);
    formData.append('stock', stock);
    formData.append('remarks', remarks);
    formData.append('star', star);
    formData.append('main_category_id', main_category_id);
    formData.append('category_id', category_id);
    formData.append('brand_id', brand_id);
    
    formData.append('img1', img1);
    formData.append('img2', img2);
    formData.append('img3', img3);
    formData.append('img4', img4);
    formData.append('color', color);
    formData.append('size', size);
    formData.append('description', description);

    // console.log([...formData.entries()]); // Debugging formData

    try {
        showLoader();
        let res = await axios.post("/create-product", formData, {
            headers: { 'Content-Type': 'multipart/form-data' },
        });
        hideLoader();
        if (res.status === 201) {
            successToast('Product Created Successfully!');
            document.getElementById("save-form").reset();
            window.location.href="/products-list"
        } else {
            errorToast("Failed to Create Product");
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