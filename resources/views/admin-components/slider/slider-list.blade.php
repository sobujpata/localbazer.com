<div class="all-Orders-Details">
    

    <div class="addProduct">
        <div class="head-newProduct">
            <h1>Add a New Slider</h1>
        </div>
        <form id="save-form">
            
            <div class="input-grid">
                <span>
                    <p>Slide Title*</p>
                    <input id="slider_title" class="slider_title" type="text" placeholder="Slide Title">
                </span>
                <span>
                    <p>Short Description*</p>
                    <input id="short_des" class="short_des" type="text" placeholder="Short Description">
                </span>
                <span>
                    <p>Price*</p>
                    <input id="price" class="price" type="text" placeholder="Price">
                </span>
                <span>
                    <p>product*</p>
                    <select name="product_id" id="product_id" style="width: 100%; height: 35px;">
                        <option value="" disabled selected>Select Product</option>
                    </select>
                </span>
                <span>
                    <p>Slide Image*</p>
                    <input id="slider_image" class="img" type="file" >
                </span>
                
            </div>
        </form>
        <button onclick="SaveForm()" class="black-button" >Publish menu</button>
        <br>
        <hr>
        <div class="head-newProduct" class="">
            <h1><u>Slider List</u></h1>
        </div>
        <br>
        <table id="tableData" width="100%">
            <thead>
                <tr>
                    <th>Ser No</th>
                    <th>Title</th>
                    <th>Short Des</th>
                    <th>Price</th>
                    <th>product</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="tableList">
                
            </tbody>
        </table>

       

    </div>
    

</div>

<script>
    getProductList()
    async function getProductList(){
        showLoader()
        let res = await axios.get('/list-product');
        hideLoader()
        // console.log(res);
        res.data.data.forEach(function (item,i) {
            let option=`<option value="${item['id']}">${item['title']}</option>`
            $("#product_id").append(option);
        })
    }
    async function SaveForm() {
        let slider_title = document.getElementById('slider_title').value;
        let short_des = document.getElementById('short_des').value;
        let price = document.getElementById('price').value;
        let product_id = document.getElementById('product_id').value;
        let slider_image = document.getElementById('slider_image').files[0];
        
        if (!slider_title) return errorToast("Title is Required!");
        if (!short_des) return errorToast("Short des is Required!");
        if (!price) return errorToast("Price is Required!");
        if (!product_id) return errorToast("Product is Required!");
        if (!slider_image) return errorToast("Image is Required!");
        

        
        let formData = new FormData();
        formData.append('title', slider_title);
        formData.append('short_des', short_des);
        formData.append('price', price);
        formData.append('product_id', product_id);
        formData.append('image', slider_image);
        

        console.log([...formData.entries()]); // Debugging formData

        try {
            showLoader();
            let res = await axios.post("/create-product-slider", formData, {
                headers: { 'Content-Type': 'multipart/form-data' },
            });
            console.log(res)
            hideLoader();
            if (res.status === 201) {
                successToast('Slider Created Successfully!');
                document.getElementById("save-form").reset();
                getSliderList();
            } else {
                errorToast("Failed to Create Slider");
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
    async function getSliderList(){
        showLoader();
        let res = await axios.get("/product-slider-list");
        hideLoader();
        // console.log(res);

        let tableList=$("#tableList");
        let tableData=$("#tableData");
    
        tableData.DataTable().destroy();
        tableList.empty();
        res.data.forEach(function (item,index) {
            // let imgUrl = item['image'];
            // console.log(imgUrl);
            let row = `<tr>
                        <td>${index+1}</td>
                        <td>${item['title']}</td>
                        <td>${item['short_des']}</td>
                        <td>${item['price']}</td>
                        <td>${item['product_id']}</td>
                        <td><img src="${item['image']}" alt="Product slider" style="width:120px;"</td>
                        <td>
                            <button class="btn btn-sm btn-outline-success editBtn" data-id="${ item['id'] }" style="padding:5px; background-color:black; border-radius:5px; color:white; ">
                                <i class="fa-solid fa-pen"></i>
                            </button>
                            <button data-path="${item['image']}" data-id="${item['id']}" class="btn deleteBtn btn-sm btn-outline-danger" style="padding:5px; background-color:red; border-radius:5px; color:white; "><i class="fa-solid fa-trash"></i></button>
                        </td>
                     </tr>`
            tableList.append(row)
        })
    
        document.querySelectorAll('.editBtn').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                window.location.href = `/product-slider-edit?id=${id}`;
            });
        });
    
        document.querySelectorAll('.deleteBtn').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                const imgPath = this.getAttribute('data-path');
                window.location.href = `/product-slider-delete?id=${id}?imgPath=${imgPath}`;
            });
        });
    
        new DataTable('#tableData',{
            order:[[0,'desc']],
            lengthMenu:[20,30,50,100,500]
        });
    }
    getSliderList();

</script>