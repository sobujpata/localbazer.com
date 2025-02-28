<div class="all-Orders-Details">
    <div class="head-newProduct">
        <h1>Edit Testimonial</h1>
        <button type="button" class="black-70-button"><a href="{{ url('/testimonial-admin') }}">Testimonial List</a></button>

    </div>

    <div class="addProduct">
        <div class="productHeader">
            <h2>Testimonial information</h2>
            
        </div>
        <form id="save-form">
            
            <div class="input-grid">
                <input class="d-none" id="testimonialId" class="testimonialId" type="text" value="{{ $testimonial->id }}">

                <span>
                    <p>Name*</p>
                    <input id="name" class="name" type="text" value="{{ $testimonial->name }}">
                </span>
                <span>
                    <p>Position*</p>
                    <input id="position" class="position" type="text" value="{{ $testimonial->position }}">
                </span>
                <span>
                    <p>Testimonial*</p>
                    <textarea name="testimonial" id="testimonial" cols="30" rows="10" style="width:100%; padding: 10px;">{{ $testimonial->testimonial }}</textarea>
                </span>
                <span>
                    <p>Testimonial Image</p>
                    <img class="" id="newImg" src="{{asset($testimonial->image)}}" style="width:150px; border-radius: 5px;"/>
                    
                    <input oninput="newImg.src=window.URL.createObjectURL(this.files[0])" type="file" name="img1" id="img1" style="white-space: 80%; float:right;">
                </span>
                
            </div>
        </form>
        <button onclick="Update()" class="black-button" >Update testimonial</button>
    </div>
</div>

<script>
   
    async function Update() {
    let testimonialId = document.getElementById('testimonialId').value;
    let name = document.getElementById('name').value;
    let position = document.getElementById('position').value;
    let testimonial = document.getElementById('testimonial').value;
    let img1 = document.getElementById('img1').files[0];
    
    
    if (!name) return errorToast("name Title is Required!");
    if (!position) return errorToast("Position is Required!");
    if (!testimonial) return errorToast("Testimonial is Required!");
    

    
    let formData = new FormData();
    
    formData.append('id', testimonialId);
    formData.append('position', position);
    formData.append('name', name);
    formData.append('testimonial', testimonial);
    formData.append('image', img1);
    

    console.log([...formData.entries()]); // Debugging formData

    try {
        showLoader();
        let res = await axios.post("/update-testimonial-setting", formData, {
            headers: { 'Content-Type': 'multipart/form-data' },
        });
        // console.log(res)
        hideLoader();
        if (res.status === 203) {
            successToast('testimonial Updated Successfully!');
            window.location.href = '/testimonial-setting';
        } else {
            errorToast("Failed to Update testimonial");
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