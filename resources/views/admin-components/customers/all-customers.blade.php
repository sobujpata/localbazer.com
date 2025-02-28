<!--============================ Manage Customers =========================-->
<div class="all-Orders-Details">


    <div class="recentCustomers">
        <div class="cardHeader">
            <h2>Manage Customers</h2>
        </div>

        <table id="tableData" class="table">
            <thead>
                <tr>
                    <td>S/L No</td>
                    <td>CUSTOMER</td>
                    <td>CUSTOMER ID</td>
                    <td>LOCATION</td>
                    <td>ORDERS</td>
                    <td>TOTAL SPENT</td>
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
        try {
            // Fetch data from the backend
            let res = await axios.get("/list-customer");
            // console.log(res);
            hideLoader();
    
            // Extract customer, profile, and order data
            let customers = res.data.customers;
            let profiles = res.data.profiles;
            let orderCount = res.data.orderCount; // Total orders from backend
            let totalPayable = res.data.totalPayable; // Total payable from backend
    
            // Map profiles by user ID for easy lookup
            let profileMap = {};
            profiles.forEach(profile => {
                profileMap[profile.user_id] = profile;
            });
    
            // Prepare table
            let tableList = $("#tableList");
            let tableData = $("#tableData");
    
            if ($.fn.DataTable.isDataTable("#tableData")) {
                tableData.DataTable().destroy();
            }
            tableList.empty();
    
            // Populate table rows
            customers.forEach((customer, index) => {
                let profile = profileMap[customer.id] || {}; // Get profile data or empty object
                let row = `
                    <tr>
                        <td>${index + 1}</td>
                        <td>
                                <span class="flex">
                                    <div class="imgBx">
                                        <img src="${profile.image_url || 'Images/default-image.jpg'}" alt="">
                                    </div>
                                    <h4>${customer.firstName || ''} ${customer.lastName || ''}<br>
                                        <span>${customer.email || ''}</span>
                                    </h4>
                                </span>
                        </td>
                        <td>${customer.id}</td>
                        <td>${profile.cus_add || 'N/A'}</td>
                        <td>${orderCount || 'N/A'}</td>
                        <td>${totalPayable || 'N/A'}</td>
                    </tr>`;
                tableList.append(row);
            });
    
            // Initialize DataTable
            new DataTable('#tableData', {
                lengthMenu: [20, 30, 50, 100, 500]
            });
    
        } catch (error) {
            console.error("Error fetching customer data:", error);
            hideLoader();
            alert("Failed to load customer data. Please try again.");
        }
    }
</script>
   