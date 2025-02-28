<style>
    .input-grid {
        display: grid;
        gap: 10px;
    }
    .preview-img {
        width: 50px;
        height: auto;
        margin-bottom: 5px;
    }
</style>
<div class="all-Orders-Details">
    <div class="head-newProduct">
        <h1>Update a Product</h1>
        <button type="button" class="black-70-button" style="background-color: #c232af; "><a href="{{ url('/products-list') }}" style="color:white;">Product List</a></button>

    </div>

    <div class="addProduct">
        <div class="productHeader">
            <h2>Product information</h2>
            {{-- {{ dd($product_detail->des) }} --}}
        </div>
        <form id="save-form">
            
            <div class="input-grid">
                <input type="hidden" value="{{ $product->id }}" id="id">
                <span>
                    <p>Title*</p>
                    <input id="title" class="title" type="text" value="{{ $product->title }}">
                </span>
                <span>
                    <p>Short Description*</p>
                    <input type="text" name="short_des" id="short_des" value="{{ $product->short_des }}">
                </span>
                <span>
                    <p>Price*</p>
                    <input type="number" value="{{ $product->price }}" name="price" id="price">
                </span>
                <span>
                    <p>Discounted Price*</p>
                    <input type="number" value="{{ $product->discount_price }}" name="discount_price" id="discount_price">
                </span>
                <span>
                    <p>Stock</p>
                    <input type="number" value="{{ $product->stock }}" name="stock" id="stock" >
                </span>
                <span>
                    <p>Remark*</p>
                    <select name="remarks" id="remarks" style="width: 100%; height: 35px;">
                        <option value="">Select Remarks</option>
                        <option @if ( $product->remark ==="popular" )
                            selected
                        @endif value="popular">Popular</option>
                        <option @if ( $product->remark ==="new" )
                            selected
                        @endif value="new">New</option>
                        <option @if ( $product->remark==="top" )
                            selected
                        @endif value="top">Top</option>
                        <option @if ( $product->remark==="special" )
                            selected
                        @endif value="special">Special</option>
                        <option @if ( $product->remark==="trending" )
                            selected
                        @endif value="trending">Trending</option>
                        <option @if ( $product->remark==="regular" )
                            selected
                        @endif value="regular">Regular</option>
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
                    <input type="number" value="{{ $product->star }}" name="star" id="star">
                </span>
                <span>
                    <p>Color</p>
                    <input type="text" value="{{ $product_detail->color ?? '' }}" name="color" id="color">
                </span>
                <span>
                    <p>Size</p>
                    <input type="text" value="{{ $product_detail->size ?? ''  }}" name="size" id="size">
                </span>
            </div>
            <span class="bio">
                <p>Description*</p>
                <textarea id="description" name="bio">{{ $product_detail->des ?? '' }}</textarea>
            </span>
            <div class="input-grid">
                @for ($i = 1; $i <= 4; $i++)
                    <span>
                        <p>Image {{ $i }}</p>
                        <img class="preview-img" id="previewImg{{ $i }}" src="{{ asset($product_detail->{'img'.$i} ?? '' ) }}" alt="Image {{ $i }}" />
                        <input 
                            type="file" 
                            name="img{{ $i }}" 
                            id="img{{ $i }}" 
                            accept="image/*" 
                            onchange="updateImagePreview(this, 'previewImg{{ $i }}')"
                        />
                    </span>
                @endfor
            </div>
            
            <input type="hidden" id="old_img1" value="{{ $product_detail->img1 ?? ''  }}">
            <input type="hidden" id="old_img2" value="{{ $product_detail->img2 ?? ''  }}">
            <input type="hidden" id="old_img3" value="{{ $product_detail->img3 ?? ''  }}">
            <input type="hidden" id="old_img4" value="{{ $product_detail->img4 ?? ''  }}">

        </form>
        <button onclick="Update()" class="black-button" >Update Product</button>
        
    </div>
</div>
<script>
    function updateImagePreview(input, previewId) {
        const file = input.files[0];
        if (file) {
            const preview = document.getElementById(previewId);
            preview.src = URL.createObjectURL(file);
        }
    }
</script>
<script>
    FillCategoryDropDown();

    async function FillCategoryDropDown(){
        // showLoader();
        let res = await axios.get("/list-main-category")
        let resSubCategory = await axios.get("/list-sub-category")
        // console.log(res);
        res.data.forEach(function (item,i) {
            let option=`<option @if ( $product->main_category_id )
                selected
            @endif value="${item['id']}">${item['categoryName']}</option>`
            $("#main_category_id").append(option);
        })
        resSubCategory.data.forEach(function (item,i) {
            let option=`<option @if ( $product->category_id )
                selected
            @endif value="${item['id']}">${item['categoryName']}</option>`
            $("#category_id").append(option);
        })

        hideLoader()
    }
    FillBrandDropdown()
    async function FillBrandDropdown(){
        let res = await axios.get('/list-brand');

        res.data.forEach(function (item,i) {
            let option=`<option @if ( $product->brand_id )
                selected
            @endif value="${item['id']}">${item['brandName']}</option>`
            $("#brand_id").append(option);
        })
    }



    async function Update() {
    let formData = new FormData();
    let id = document.getElementById('id').value;
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

    // Add other form data
    formData.append('id', id);
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
    formData.append('color', color);
    formData.append('size', size);
    formData.append('description', description);

    // Check each image and append either the new file or the old image path
    for (let i = 1; i <= 4; i++) {
        let file = document.getElementById(`img${i}`).files[0];
        let oldImage = document.getElementById(`old_img${i}`)?.value; // Assuming you pass the old image URL via hidden input
        if (file) {
            formData.append(`img${i}`, file);
        } else if (oldImage) {
            formData.append(`img${i}`, oldImage);  // Append the old image path if no new image is selected
        }
    }
 console.log([...formData.entries()]); // Debugging formData
    try {
        showLoader();
        let res = await axios.post("/update-product", formData, {
            headers: { 'Content-Type': 'multipart/form-data' },
        });
        hideLoader();
        if (res.status === 200) {
            successToast('Product Updated Successfully!');
            window.location.href = '/products-list';
        } else {
            errorToast("Failed to Update Product");
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