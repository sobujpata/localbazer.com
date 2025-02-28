<div class="all-Orders-Details">
    

    <div class="addProduct">
        <div class="head-newProduct">
            <h1>Add a New Offer Card</h1>
        </div>
        <form id="save-form">
            
            <div class="input-grid">
                <span>
                    <p>Card Title*</p>
                    <input id="card_title" class="card_title" type="text" placeholder="Tard Title">
                </span>
                <span>
                    <p>Short Description*</p>
                    <input id="short_des" class="short_des" type="text" placeholder="Short Description">
                </span>
                <span>
                    <p>Discount*</p>
                    <input id="discount" class="discount" type="text" placeholder="Discount">
                </span>
                
                <span>
                    <p>Card Image*</p>
                    <input id="image" class="img" type="file" >
                </span>
                
            </div>
        </form>
        <button onclick="SaveForm()" class="black-button" >Publish</button>
        <br>
        <br>
        <hr>
        <div class="head-newProduct" class="">
            <h1><u>Card List</u></h1>
        </div>
        <br>
        <table id="tableData" width="100%">
            <thead>
                <tr>
                    <th>Ser No</th>
                    <th>Title</th>
                    <th>Short Des</th>
                    <th>Discount</th>
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
    
    async function SaveForm() {
        let card_title = document.getElementById('card_title').value;
        let short_des = document.getElementById('short_des').value;
        let discount = document.getElementById('discount').value;
        let image = document.getElementById('image').files[0];
        
        if (!card_title) return errorToast("Title is Required!");
        if (!short_des) return errorToast("Short des is Required!");
        if (!discount) return errorToast("discount is Required!");
        if (!image) return errorToast("Image is Required!");
        

        
        let formData = new FormData();
        formData.append('title', card_title);
        formData.append('short_des', short_des);
        formData.append('discount', discount);
        formData.append('image', image);
        

        console.log([...formData.entries()]); // Debugging formData

        try {
            showLoader();
            let res = await axios.post("/create-offer-card", formData, {
                headers: { 'Content-Type': 'multipart/form-data' },
            });
            console.log(res)
            hideLoader();
            if (res.status === 201) {
                successToast('Card Created Successfully!');
                document.getElementById("save-form").reset();
                getCardList();
            } else {
                errorToast("Failed to Create Card");
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
    async function getCardList(){
        showLoader();
        let res = await axios.get("/offer-card-list");
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
                        <td>${item['title']}</td>
                        <td>${item['short_des']}</td>
                        <td>${item['discount']}</td>
                        <td><img src="${item['image']}" alt="Product Card" style="width:120px;"</td>
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
                window.location.href = `/offer-card-edit?id=${id}`;
            });
        });
    
        document.querySelectorAll('.deleteBtn').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                const imgPath = this.getAttribute('data-path');
                window.location.href = `/offer-card-delete?id=${id}?imgPath=${imgPath}`;
            });
        });
    
        new DataTable('#tableData',{
            order:[[0,'desc']],
            lengthMenu:[20,30,50,100,500]
        });
    }
    getCardList();

</script>