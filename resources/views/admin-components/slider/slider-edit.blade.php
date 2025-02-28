<div class="all-Orders-Details">
    <div class="head-newProduct">
        <h1>Edit Slider</h1>
        <button type="button" class="black-70-button"><a href="{{ url('/product-slider-admin') }}">Slider List</a></button>

    </div>

    <div class="addProduct">
        <div class="productHeader">
            <h2>slider information</h2>
            
        </div>
        <form id="save-form">
            
            <div class="input-grid">
                <input class="d-none" id="sliderId" class="sliderId" type="text" value="{{ $slider->id }}">

                <span>
                    <p>Slider title*</p>
                    <input id="sliderTitle" class="sliderTitle" type="text" value="{{ $slider->title }}">
                </span>
                <span>
                    <p>Short Des*</p>
                    <input id="short_desUpdate" class="short_des" type="text" value="{{ $slider->short_des }}">
                </span>
                <span>
                    <p>Price*</p>
                    <input id="priceUpdate" class="priceUpdate" type="text" value="{{ $slider->price }}">
                </span>
                <span>
                    <p>Product*</p>
                    <select name="product_id" id="product_id" style="width: 100%; height: 35px;">
                        <option value="" disabled selected>Select Product</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}" @if ($product->id == $slider->product_id)
                                selected
                            @endif>{{ $product->title}}</option>
                        @endforeach
                    </select>
                </span>
                
           
                <span>
                    <p>slider Image</p>
                    <img class="" id="newImg" src="{{asset($slider->image)}}" style="width:150px;"/>
                    
                    <input oninput="newImg.src=window.URL.createObjectURL(this.files[0])" type="file" name="img1" id="img1" style="white-space: 80%; float:right;">
                </span>
                
            </div>
        </form>
        <button onclick="Update()" class="black-button" >Update slider</button>
    </div>
</div>

<script>
   
    async function Update() {
    let sliderId = document.getElementById('sliderId').value;
    let sliderTitle = document.getElementById('sliderTitle').value;
    let short_desUpdate = document.getElementById('short_desUpdate').value;
    let priceUpdate = document.getElementById('priceUpdate').value;
    let product_id = document.getElementById('product_id').value;
    let img1 = document.getElementById('img1').files[0];
    
    
    if (!sliderTitle) return errorToast("Slider Title is Required!");
    if (!short_desUpdate) return errorToast("Short Des Title is Required!");
    if (!priceUpdate) return errorToast("Price Title is Required!");
    if (!product_id) return errorToast("Product Title is Required!");
    

    
    let formData = new FormData();
    
    formData.append('id', sliderId);
    formData.append('title', sliderTitle);
    formData.append('short_des', short_desUpdate);
    formData.append('price', priceUpdate);
    formData.append('product_id', product_id);
    formData.append('image', img1);
    

    console.log([...formData.entries()]); // Debugging formData

    try {
        showLoader();
        let res = await axios.post("/update-product-slider", formData, {
            headers: { 'Content-Type': 'multipart/form-data' },
        });
        // console.log(res)
        hideLoader();
        if (res.status === 200) {
            successToast('slider Updated Successfully!');
            window.location.href = '/product-slider-admin';
        } else {
            errorToast("Failed to Update slider");
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