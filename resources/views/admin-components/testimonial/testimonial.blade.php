<div class="all-Orders-Details">
    

    <div class="addProduct">
        
        <div class="head-newProduct" class="">
            <h1><u>Slider List</u></h1>
        </div>
        <br>
        <table id="tableData" width="100%">
            <thead>
                <tr>
                    <th>Ser No</th>
                    <th>name</th>
                    <th>Positon</th>
                    <th>Testimonial</th>
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

    async function getSliderList(){
        showLoader();
        let res = await axios.get("/testimonial-setting-list");
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
                        <td>${item['name']}</td>
                        <td>${item['position']}</td>
                        <td>${item['testimonial']}</td>
                        <td><img src="${item['image']}" alt="Product slider" style="width:120px;"></td>
                        <td>
                            <button class="btn btn-sm btn-outline-success editBtn" data-id="${ item['id'] }" style="padding:5px; background-color:black; border-radius:5px; color:white; ">
                                <i class="fa-solid fa-pen"></i>
                            </button>
                        </td>
                     </tr>`
            tableList.append(row)
        })
    
        document.querySelectorAll('.editBtn').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                window.location.href = `/testimonial-setting-edit?id=${id}`;
            });
        });
    
        new DataTable('#tableData',{
            order:[[0,'desc']],
            lengthMenu:[20,30,50,100,500]
        });
    }
    getSliderList();

</script>