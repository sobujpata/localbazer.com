<div class="all-Orders-Details">
    <div class="head-newProduct">
        <h1>Edit Sub Menu <i class="fas fa-map-marker-question    "></i></h1>
        <button type="button" class="black-70-button"><a href="{{ url('/add-Sub Menu-menu') }}">Sub Menu Menu List</a></button>

    </div>

    <div class="addProduct">
        <div class="productHeader">
            <h2>Sub Menu Menu information</h2>
            
        </div>
        <form id="save-form">
            {{-- @dd($subMenu) --}}
            <div class="input-grid">
                <input class="d-none" id="subMenuId" class="subMenuId" type="text" value="{{ $subMenu->id }}">
                <span>
                    <p>Sub Menu Name*</p>
                    <input id="subMenuName" class="subMenuName" type="text" value="{{ $subMenu->name }}">
                </span>
                <span>
                    <p>Url*</p>
                    <input id="subMenuUrl" class="subMenuUrl" type="text" value="{{ $subMenu->url }}">
                </span>
                <span>
                    <p>Main Menu Name*</p>
                    <select name="mainMenu" id="mainMenu_id" style="width: 100%; padding:8px;">
                        <option value="" disabled selected> Select main menu</option>
                        @foreach ($mainMenu as $menu)
                        <option value="{{ $menu->id }}" @if ($menu->id == $subMenu->main_menu_id)
                            selected
                        @endif>{{ $menu->name }}</option>
                        @endforeach
                    </select>
                </span>
                
            </div>
        </form>
        <button onclick="Update()" class="black-button" >Update subMenu</button>
       

    </div>
</div>

<script>
    async function Update() {
    let subMenuId = document.getElementById('subMenuId').value;
    let subMenuName = document.getElementById('subMenuName').value;
    let subMenuUrl = document.getElementById('subMenuUrl').value;
    let mainMenu_id = document.getElementById('mainMenu_id').value;
    
    
    if (!subMenuName) return errorToast("Sub Menu Menu Name is Required!");
    if (!subMenuUrl) return errorToast("Url is Required!");
    if (!mainMenu_id) return errorToast("Main Menu Name is Required!");
    

    
    let formData = new FormData();
    
    formData.append('id', subMenuId);
    formData.append('name', subMenuName);
    formData.append('url', subMenuUrl);
    formData.append('main_menu_id', mainMenu_id);
    

    console.log([...formData.entries()]); // Debugging formData

    try {
        showLoader();
        let res = await axios.post("/update-sub", formData, {
            headers: { 'Content-Type': 'multipart/form-data' },
        });
        // console.log(res)
        hideLoader();
        if (res.status === 203) {
            successToast('Sub Menu Updated Successfully!');
            window.location.href = '/add-dropdown-menu';
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