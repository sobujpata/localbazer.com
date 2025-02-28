<div class="all-Orders-Details">
    <div class="head-newProduct">
        <h1>Edit service</h1>
        <button type="button" class="black-70-button"><a href="{{ url('/services-setting') }}">Service List</a></button>

    </div>

    <div class="addProduct">
        <div class="productHeader">
            <h2>Service information</h2>
            
        </div>
        <form id="save-form">
            
            <div class="input-grid">
                <input class="d-none" id="serviceId" class="serviceId" type="text" value="{{ $service->id }}">

                <span>
                    <p>Service Title*</p>
                    <input id="serviceTitle" class="serviceTitle" type="text" value="{{ $service->title }}">
                </span>
                <span>
                    <p>Service Short des*</p>
                    <input id="serviceShortDes" class="serviceShortDes" type="text" value="{{ $service->short_des }}">
                </span>
                
                <span>
                    <p>Service Icon*</p>
                    <input id="serviceIcon" class="serviceIcon" type="text" value="{{ $service->icon }}">
                </span>
            </div>
        </form>
        <button onclick="Update()" class="black-button" >Update service</button>
    </div>
</div>

<script>
   
    async function Update() {
    let serviceId = document.getElementById('serviceId').value;
    let serviceTitle = document.getElementById('serviceTitle').value;
    let serviceShortDes = document.getElementById('serviceShortDes').value;
    let serviceIcon = document.getElementById('serviceIcon').value;
    
    
    if (!serviceTitle) return errorToast("Service title is Required!");
    if (!serviceShortDes) return errorToast("Service des is Required!");
    if (!serviceIcon) return errorToast("Service icon is Required!");
    

    
    let formData = new FormData();
    
    formData.append('id', serviceId);
    formData.append('title', serviceTitle);
    formData.append('short_des', serviceShortDes);
    formData.append('icon', serviceIcon);
    

    console.log([...formData.entries()]); // Debugging formData

    try {
        showLoader();
        let res = await axios.post("/update-services-setting", formData, {
            headers: { 'Content-Type': 'multipart/form-data' },
        });
        // console.log(res)
        hideLoader();
        if (res.status === 200) {
            successToast('Service Updated Successfully!');
            window.location.href = '/services-setting';
        } else {
            errorToast("Failed to Update service");
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