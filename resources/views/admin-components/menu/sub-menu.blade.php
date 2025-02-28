<div class="all-Orders-Details">
    

    <div class="addProduct">
        <div class="head-newProduct">
            <h1>Add a New Sub Menu</h1>
            <button type="button" class="black-70-button"><a href="{{ url('/add-main-menu') }}" style="color:#fff;">Add Main Menu</a></button>

        </div>
        <form id="save-form">
            
            <div class="input-grid">
                <span>
                    <p>Sub Name*</p>
                    <input id="subMenu" class="subMenu" type="text" placeholder="Menu Name">
                </span>
                <span>
                    <p>Url*</p>
                    <input id="subUrl" class="subUrl" type="text" placeholder="Url Name">
                </span>
                <span>
                    <p>Main Menu*</p>
                    <select id="mainMenuId" class="mainMenuId" type="text" style="width: 100%; height: 35px;">
                        <option value="">Select Category</option>
                        
                    </select>
                </span>
                
            </div>
            <button type="reset" id="menu-form" class="black-70-button">Clear Form</button>
            <button onclick="SaveMenu()" class="black-button" >Publish menu</button>
        </form>
        <br>
        <hr>
        <div class="head-newProduct" class="">
            <h1><u>Main Menu List</u></h1>
        </div>
        <br>
        @if(Session::has('error'))
         <p style="background-color:red; color:white; padding: 10px; border-radius: 5px;">{{ Session::get('error') }}</p>
        @endif
        @if(Session::has('message'))
         <p style="background-color:rgb(21, 136, 243); color:rgb(26, 23, 23); padding: 10px; border-radius: 5px;">{{ Session::get('message') }}</p>
        @endif
        <br>
        <table id="tableData" width="100%">
            <thead>
                <tr>
                    <th>Ser No</th>
                    <th>Sub Menu Name</th>
                    <th>URL</th>
                    <th>Menu Name</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="tableList">
                
            </tbody>
        </table>

       

    </div>
    

</div>

<script>
    FillCategoryDropDown();

    async function FillCategoryDropDown(){
        // showLoader();
        let res = await axios.get("/menu-list")

        // console.log(res);
        res.data.forEach(function (item,i) {
            let option=`<option value="${item['id']}">${item['name']}</option>`
            $("#mainMenuId").append(option);
        })
        

        hideLoader()
    }
    async function SaveMenu() {
        let subMenu = document.getElementById('subMenu').value;
        let subUrl = document.getElementById('subUrl').value;
        let mainMenuId = document.getElementById('mainMenuId').value;
        
        if (!subMenu) return errorToast("Menu is Required!");
        if (!subUrl) return errorToast("Url is Required!");
        if (!mainMenuId) return errorToast("Main Menu is Required!");
        

        
        let formData = new FormData();
        formData.append('name', subMenu);
        formData.append('url', subUrl);
        formData.append('main_menu_id', mainMenuId);
        

        // console.log([...formData.entries()]); // Debugging formData

        try {
            showLoader();
            let res = await axios.post("/sub-menu-create", formData, {
                headers: { 'Content-Type': 'multipart/form-data' },
            });
            console.log(res)
            hideLoader();
            if (res.status === 201) {
                successToast('Sub Menu Created Successfully!');
                document.getElementById("save-form").reset();
            } else {
                errorToast("Failed to Create menu");
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
    async function getListMenu(){
        showLoader();
        let res = await axios.get("/sub-menu-list");
        hideLoader();
        // console.log(res);

        let tableList=$("#tableList");
        let tableData=$("#tableData");
    
        tableData.DataTable().destroy();
        tableList.empty();
        res.data.forEach(function (item,index) {
            let row = `<tr>
                        <td>${index+1}</td>
                        <td>${item['name']}</td>
                        <td>${item['url']}</td>
                        <td>${item['main_menu']["name"]}</td>
                        <td>${item['created_at']}</td>
                        <td>
                            <button class="btn btn-sm btn-outline-success editBtn" data-id="${ item['id'] }" style="padding:5px; background-color:black; border-radius:5px; color:white; ">
                                <i class="fa-solid fa-pen"></i>
                            </button>
                            <button data-id="${item['id']}" class="btn deleteBtn btn-sm btn-outline-danger" style="padding:5px; background-color:red; border-radius:5px; color:white; "><i class="fa-solid fa-trash"></i></button>
                        </td>
                     </tr>`
            tableList.append(row)
        })
    
        document.querySelectorAll('.editBtn').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                window.location.href = `/sub-edit?id=${id}`;
            });
        });
    
        document.querySelectorAll('.deleteBtn').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                window.location.href = `/sub-delete?id=${id}`;
            });
        });
    
        new DataTable('#tableData',{
            // order:[[0,'desc']],
            lengthMenu:[20,30,50,100,500]
        });
    }
    getListMenu();

</script>