<!--============================ New Customers =========================-->
<div class="recentCustomers">
    <div class="cardHeader">
        <h2>Recent Customers</h2>
        <a href="{{ url('/customers') }}" class="btn">All</a>
    </div>

    <table id="tableDataCustomer">
        
        <thead>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Name & City</th>
            </tr>
        </thead>
        <tbody id="tableListCustomer">

        </tbody>

        
    </table>
</div>

<script>
    getCustomer();
    
    async function getCustomer() {
        showLoader();
        try {
            // Fetch data from the backend
            let res = await axios.get("/list-customer");
            // console.log(res);
            hideLoader();
    
            // Extract customer, profile, and order data
            let customers = res.data.customers;
            let profiles = res.data.profiles;
            // let orderCount = res.data.orderCount; // Total orders from backend
            // let totalPayable = res.data.totalPayable; // Total payable from backend
    
            // Map profiles by user ID for easy lookup
            let profileMap = {};
            profiles.forEach(profile => {
                profileMap[profile.user_id] = profile;
            });
    
            // Prepare table
            let tableListCustomer = $("#tableListCustomer");
            let tableDataCustomer = $("#tableDataCustomer");
    
            if ($.fn.DataTable.isDataTable("#tableDataCustomer")) {
                tableDataCustomer.DataTable().destroy();
            }
            tableListCustomer.empty();
    
            // Populate table rows
            customers.forEach((customer, index) => {
                let profile = profileMap[customer.id] || {}; // Get profile data or empty object
                let row = `
                    <tr>
                        <td>${customer.id || ''}</td>
                        <td width="60px">
                            <div class="imgBx"><img src="${profile.image_url || 'N/A'}" alt=""></div>
                        </td>
                        <td>
                            <h4>${customer.firstName || ''}<br> <span>${profile.cus_city || 'N/A'}</span></h4>
                        </td>
                    </tr>`;
                tableListCustomer.append(row);
            });
    
            // Initialize DataTable
            new DataTable('#tableDataCustomer', {
                searching: false,
                lengthMenu: [20, 30, 50, 100, 500],
                order:[[0,'desc']],
            });
    
        } catch (error) {
            console.error("Error fetching customer data:", error);
            hideLoader();
            alert("Failed to load customer data. Please try again.");
        }
    }
</script>