<!--================================= Manage Products ===============================  -->

<div class="all-Orders-Details">
    <div class="recentCustomers">
        <div class="cardHeader">
            <h2>Deal Of The Day List</h2>
            <button type="button" class="black-70-button" style="margin-bottom:10px;"><a href="{{ url('/deal-of-the-day-add') }}">Deal of the day Add</a></button>

        </div>

        <table class="table" id="tableData">
            <thead>
                <tr>
                    <td>Ser No</td>
                    <td>IMAGE</td>
                    <td>Product NAME</td>
                    <td>Sold</td>
                    <td>Offer Up To</td>
                    <td>ACTIONS</td>
                </tr>
            </thead>

            <tbody id="tableList">              

            </tbody>
        </table>
    </div>
</div>

<script>

    getList();
    
    
    async function getList() {
        showLoader();
        let res=await axios.get("/deal-of-the-day-list");
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
                        <td><img src="${item['image_url']}" style="width: 70px; height: 80px;" alt="No Image"/></td>
                        <td>${item['products']['title']}</td>
                        <td>${item['sold']}</td>
                        <td>${item['count_down']}</td>
                        <td>
                            <button class="btn btn-sm btn-outline-success editBtn" data-id="${ item['id'] }" style="padding:5px; background-color:black; border-radius:5px; color:white; ">
                                <i class="fa-solid fa-pen"></i>
                            </button>
                            <button data-path="${item['image_url']}" data-id="${item['id']}" class="btn deleteBtn btn-sm btn-outline-danger" style="padding:5px; background-color:red; border-radius:5px; color:white; "><i class="fa-solid fa-trash"></i></button>
                        </td>
                     </tr>`
            tableList.append(row)
        })
    
        document.querySelectorAll('.editBtn').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                window.location.href = `/deal-of-the-day-edit?id=${id}`;
            });
        });
    
        document.querySelectorAll('.deleteBtn').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                const imgPath = this.getAttribute('data-path');
                window.location.href = `/deal-of-the-day-delete?id=${id}?imgPath=${imgPath}`;
            });
        });
    
        new DataTable('#tableData',{
            // order:[[0,'desc']],
            lengthMenu:[20,30,50,100,500]
        });
    
    }
    </script>
    
    