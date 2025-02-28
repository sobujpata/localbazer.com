<div class="all-Orders-Details">
    

    <div class="addProduct">
        <div class="head-newProduct">
            <h1><u>Add a New Service</u></h1>
        </div>
        <form id="save-form">
            
            <div class="input-grid">
                <span>
                    <p>Title*</p>
                    <input id="title" class="title" type="text" placeholder="Title">
                </span>
                <span>
                    <p>Short Des*</p>
                    <input id="short_des" class="short_des" type="text" placeholder="Short des">
                </span>
                <span>
                    <p>Icon class*</p>
                    <input id="icon" class="icon" type="text" placeholder="Short des">
                </span>
                
            </div>
        </form>
        <button onclick="SaveForm()" class="black-button" >Publish menu</button>
        <br>
        <br>
        <hr>
        <div class="head-newProduct" class="">
            <h1><u>Service List</u></h1>
        </div>
        <br>
        <table id="tableData" width="100%">
            <thead>
                <tr>
                    <th>Ser No</th>
                    <th>Title</th>
                    <th>Short Des</th>
                    <th>Icon class</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="tableList">
                
            </tbody>
        </table>

       

    </div>
    

</div>

<script>
    async function SaveForm() {
        let title = document.getElementById('title').value;
        let short_des = document.getElementById('short_des').value;
        let icon = document.getElementById('icon').value;
        
        if (!title) return errorToast("Title is Required!");
        if (!short_des) return errorToast("short_des is Required!");
        if (!icon) return errorToast("icon is Required!");
        

        
        let formData = new FormData();
        formData.append('title', title);
        formData.append('short_des', short_des);
        formData.append('icon', icon);
        

        // console.log([...formData.entries()]); // Debugging formData

        try {
            showLoader();
            let res = await axios.post("/create-services-setting", formData, {
                headers: { 'Content-Type': 'multipart/form-data' },
            });
            console.log(res)
            hideLoader();
            if (res.status === 201) {
                successToast('Service Created Successfully!');
                document.getElementById("save-form").reset();
                getService();
            } else {
                errorToast("Failed to Create Service");
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
    async function getService(){
        showLoader();
        let res = await axios.get("/services-setting-list");
        hideLoader();
        console.log(res);

        let tableList=$("#tableList");
        let tableData=$("#tableData");
    
        tableData.DataTable().destroy();
        tableList.empty();
        res.data.forEach(function (item,index) {
            
            let row = `<tr>
                        <td>${index+1}</td>
                        <td>${item['title']}</td>
                        <td>${item['short_des']}</td>
                        <td>${item['icon']}</td>
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
                window.location.href = `/services-setting-edit?id=${id}`;
            });
        });
    
        document.querySelectorAll('.deleteBtn').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                window.location.href = `/services-setting-delete?id=${id}`;
            });
        });
    
        new DataTable('#tableData',{
            order:[[0,'desc']],
            lengthMenu:[20,30,50,100,500]
        });
    }
    getService();

</script>