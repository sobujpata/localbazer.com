<!--================================= Manage Products ===============================  -->

<div class="all-Orders-Details">
    <div class="recentCustomers">
        <div class="cardHeader">
            <h2>Brand List</h2>
            <button type="button" class="black-70-button" style="margin-bottom:10px;"><a href="{{ url('/brand-add') }}">Brand Add</a></button>

        </div>

        <table class="table" id="tableData">
            <thead>
                <tr>
                    <td>Ser No</td>
                    <td>IMAGE</td>
                    <td>BRAND NAME</td>
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
        let res=await axios.get("/list-brand");
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
                        <td><img src="${item['brandImg']}" style="width: 70px; height: 80px;" alt="No Image"/></td>
                        <td>${item['brandName']}</td>
                        <td>
                            <button class="btn btn-sm btn-outline-success editBtn" data-id="${ item['id'] }" style="padding:5px; background-color:black; border-radius:5px; color:white; ">
                                <i class="fa-solid fa-pen"></i>
                            </button>
                            <button data-path="${item['brandImg']}" data-id="${item['id']}" class="btn deleteBtn btn-sm btn-outline-danger" style="padding:5px; background-color:red; border-radius:5px; color:white; "><i class="fa-solid fa-trash"></i></button>
                        </td>
                     </tr>`
            tableList.append(row)
        })
    
        document.querySelectorAll('.editBtn').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                window.location.href = `/brand-edit?id=${id}`;
            });
        });
    
        document.querySelectorAll('.deleteBtn').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                const imgPath = this.getAttribute('data-path');
                window.location.href = `/brand-delete?id=${id}?imgPath=${imgPath}`;
            });
        });
    
        new DataTable('#tableData',{
            // order:[[0,'desc']],
            lengthMenu:[20,30,50,100,500]
        });
    
    }
    </script>
    
    