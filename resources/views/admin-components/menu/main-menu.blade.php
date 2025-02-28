<div class="all-Orders-Details">
    

    <div class="addProduct">
        <div class="head-newProduct">
            <h1>Add a New Main Menu</h1>
            <button type="button" class="black-70-button"><a href="{{ url('/add-dropdown-menu') }}" style="color:#fff;">Add Sub Menu</a></button>

        </div>
       
        <form id="save-form">
            
            <div class="input-grid">
                <span>
                    <p>Menu Name*</p>
                    <input id="menuName" class="menuName" type="text" placeholder="Menu Name">
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
    async function SaveMenu() {
        let menuName = document.getElementById('menuName').value;
        
        if (!menuName) return errorToast("Menu is Required!");
        

        
        let formData = new FormData();
        formData.append('name', menuName);
        

        // console.log([...formData.entries()]); // Debugging formData

        try {
            showLoader();
            let res = await axios.post("/menu-create", formData, {
                headers: { 'Content-Type': 'multipart/form-data' },
            });
            console.log(res)
            hideLoader();
            if (res.status === 201) {
                successToast('Menu Created Successfully!');
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
        let res = await axios.get("/menu-list");
        hideLoader();
        console.log(res);

        let tableList=$("#tableList");
        let tableData=$("#tableData");
    
        tableData.DataTable().destroy();
        tableList.empty();
        res.data.forEach(function (item,index) {
            // let imgUrl = item['image'];
            // console.log(imgUrl);
            let row = `<tr>
                        <td>${index+1}</td>
                        <td>${item['name']}</td>
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
                window.location.href = `/menu-edit?id=${id}`;
            });
        });
    
        document.querySelectorAll('.deleteBtn').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                window.location.href = `/menu-delete?id=${id}`;
            });
        });
    
        new DataTable('#tableData',{
            // order:[[0,'desc']],
            lengthMenu:[20,30,50,100,500]
        });
    }
    getListMenu();

</script>