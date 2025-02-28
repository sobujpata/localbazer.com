<div class="recentOrders">
    <div class="cardHeader">
        <h2>Recent Orders</h2>
        <a href="{{ url('/orders') }}" class="btn">View All</a>
    </div>

    <table id="tableData">
        <thead>
            <tr>
                <td>No.</td>
                <td>Name</td>
                <td>Price</td>
                <td>Payment</td>
                <td>Status</td>
            </tr>
        </thead>

        <tbody id="tableList">
            
        </tbody>
    </table>
</div>
<script>

    getList();
    
    
    async function getList() {
        showLoader();
        let res=await axios.get("/list-invoice");
        hideLoader();
        // console.log(res);
        let tableList=$("#tableList");
        let tableData=$("#tableData");
    
        tableData.DataTable().destroy();
        tableList.empty();
        res.data.forEach(function (item,index) {
            let buttonClass = '';
                if (item['delivery_status'] === 'Pending') {
                    buttonClass = 'btn-blue';  // Blue for Pending
                } else if (item['delivery_status'] === 'Processing') {
                    buttonClass = 'btn-black'; // Black for Processing
                }
                else if (item['delivery_status'] === 'Completed') {
                    buttonClass = 'btn-yellow'; // Black for Processing
                }
                else if (item['delivery_status'] === 'Return') {
                    buttonClass = 'btn-red'; // Black for Processing
                }
            let row = `<tr>
                        <td>${item['id']}</td>
                        <td>${item['ship_details']}</td>
                        <td>${item['total']}</td>
                        <td>${item['payable']}</td>
                        <td>
                            <button style="padding:10px; border-radius:5px;" class="modalBtn ${buttonClass}">${item['delivery_status']}</button>

                        </td>
                        
                     </tr>`
            tableList.append(row)
        })
    
        document.querySelectorAll('.editBtn').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                window.location.href = `/sub-category-edit?id=${id}`;
            });
        });
    
        document.querySelectorAll('.deleteBtn').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                const imgPath = this.getAttribute('data-path');
                window.location.href = `/sub-category-delete?id=${id}?imgPath=${imgPath}`;
            });
        });
    
        new DataTable('#tableData',{
            order:[[0,'desc']],
            lengthMenu:[20,30,50,100,500]
        });
    
    }
</script>