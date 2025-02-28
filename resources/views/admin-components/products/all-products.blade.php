<!--================================= Manage Products ===============================  -->

<div class="all-Orders-Details">
    <div class="recentCustomers">
        <div class="cardHeader">
            <h2>Manage Products</h2>
        </div>
        
        <table class="table" id="tableData">
            <thead>
                <tr>
                    <td>Ser No</td>
                    <td>IMAGE</td>
                    <td>NAME</td>
                    <td>MAIN CATEGORY</td>
                    <td>SUB CATEGORY</td>
                    <td>BRAND</td>
                    <td>QTY</td>
                    <td>PRICE</td>
                    <td>Dec Price</td>
                    <td>Remarks</td>
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
        let res=await axios.get("/list-product");
        hideLoader();
    console.log(res);
        let tableList=$("#tableList");
        let tableData=$("#tableData");
    
        tableData.DataTable().destroy();
        tableList.empty();
        res.data.data.forEach(function (item,index) {
            // let imgUrl = item['image'];
            // console.log(imgUrl);
            let row = `<tr>
                        <td>${index+1}</td>
                        <td><img src="${item['image']}" style="width: 70px; height: 80px;" alt="No Image"/></td>
                        <td>${item['title']}</td>
                        <td>${item['main_category_id']}</td>
                        <td>${item['category_id']}</td>
                        <td>${item['brand_id']}</td>
                        <td>${item['stock']}</td>
                        <td>${item['price']}</td>
                        <td>${item['discount_price']}</td>
                        <td>${item['remark']}</td>
                        <td>
                            <button class="btn btn-sm btn-outline-success editBtn" data-id="${ item['id'] }" style="padding:5px; background-color:black; border-radius:5px; color:white; ">
                                <i class="fa-solid fa-pen"></i>
                            </button>
                            <button data-id="${item['id']}" class="btn deleteBtn btn-sm btn-outline-danger" style="padding:5px; background-color:red; border-radius:5px; color:white; ">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </td>
                     </tr>`
            tableList.append(row)
        })
    
        document.querySelectorAll('.editBtn').forEach(button => {
            button.addEventListener('click', function () {
                const productId = this.getAttribute('data-id');
                window.location.href = `/dashboard/product-edit?id=${productId}`;
            });
        });
        document.querySelectorAll('.deleteBtn').forEach(button => {
            button.addEventListener('click', function () {
                const productId = this.getAttribute('data-id');
                window.location.href = `/delete-product?id=${productId}`;
            });
        });
    
        new DataTable('#tableData',{
            // order:[[0,'desc']],
            lengthMenu:[20,30,50,100,500]
        });
        

    }
    </script>
    
    @if (session('error'))
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    errorToast("{{ session('error') }}");
                });
        </script>
    @endif

    @if (session('message'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                successToast("{{ session('message') }}");
            });
        </script>
    @endif