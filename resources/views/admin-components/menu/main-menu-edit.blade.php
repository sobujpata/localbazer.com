<div class="all-Orders-Details">
    <div class="head-newProduct">
        <h1>Edit Main <i class="fas fa-map-marker-question    "></i></h1>
        <button type="button" class="black-70-button"><a href="{{ url('/add-main-menu') }}">Main Menu List</a></button>

    </div>

    <div class="addProduct">
        <div class="productHeader">
            <h2>Main Menu information</h2>
            
        </div>
        <form id="save-form">
            {{-- @dd($mainMenu) --}}
            <div class="input-grid">
                <input class="d-none" id="mainMenuId" class="mainMenuId" type="text" value="{{ $mainMenu->id }}">
                <span>
                    <p>Main Menu Name*</p>
                    <input id="mainMenuName" class="mainMenuName" type="text" value="{{ $mainMenu->name }}">
                </span>
                
            </div>
        </form>
        <button onclick="Update()" class="black-button" >Update mainMenu</button>


       

    </div>
</div>

<script>
   
    async function Update() {
    let mainMenuId = document.getElementById('mainMenuId').value;
    let mainMenuName = document.getElementById('mainMenuName').value;
    
    
    if (!mainMenuName) return errorToast("Main Menu Name is Required!");
    

    
    let formData = new FormData();
    
    formData.append('id', mainMenuId);
    formData.append('name', mainMenuName);
    

    console.log([...formData.entries()]); // Debugging formData

    try {
        showLoader();
        let res = await axios.post("/update-menu", formData, {
            headers: { 'Content-Type': 'multipart/form-data' },
        });
        // console.log(res)
        hideLoader();
        if (res.status === 203) {
            successToast('Main Menu Updated Successfully!');
            window.location.href = '/add-main-menu';
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