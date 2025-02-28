<!--==================== Order List =====================-->
<div class="all-Orders-Details">
    <div class="recentOrders">
        <div class="cardHeader">
            <h2>All Orders</h2>
        </div>

        <table id="tableData">
            <thead>
                <tr>
                    <td>NO.</td>
                    <td>NAME</td>
                    <td>DATE</td>
                    <td>PRICE</td>
                    <td>PAYMENT</td>
                    <td>STATUS</td>
                    <td>action</td>
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
        let res = await axios.get("/list-invoice");
        hideLoader();
        // console.log(res);

        let tableList = $("#tableList");
        let tableData = $("#tableData");

        if ($.fn.DataTable.isDataTable("#tableData")) {
            tableData.DataTable().destroy();
        }
        tableList.empty();

        res.data.forEach((item, index) => {
            let modalId = `modal-${item['id']}`;
            let buttonId = `btn-${item['id']}`;
            // Set button color based on delivery status
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
            // Table row with modal trigger
            let row = `
                <tr>
                    <td>${index + 1}</td>
                    <td>${item['ship_details']}</td>
                    <td>${item['created_at']}</td>
                    <td>${item['total']}</td>
                    <td>${item['payable']}</td>
                    <td>
                        <button id="${buttonId}" style="padding:7px; border-radius:5px; margin-bottom:5px;" class="modalBtn ${buttonClass}">${item['delivery_status']}</button>
                        
                        <!-- Modal -->
                        <div id="${modalId}" class="modal" style="display: none;">
                            <div class="modal-content" style="width: 400px; ">
                                <div class="modal-header" style="border-bottom: 1px solid #ddd; padding-bottom: 10px;">
                                    <span class="close" data-modal-id="${modalId}" style="cursor: pointer; font-size: 20px;">&times;</span>
                                    <h2 style="margin: 0; font-size: 18px; text-align: center;">Update Delivery Status</h2>
                                </div>
                                <div class="modal-body" style="margin: 10px 0; padding: 10px;">
                                    <label for="updateID-${item['id']}" style="font-size: 14px; color:black; display:block; margin-bottom: 5px;">Delivery Status:</label>
                                    <select id="delivery_status-${item['id']}" class="form-select" style="width: 100%; height: 35px;">
                                        <option value="">Select Delivery Status</option>
                                        <option value="Pending" ${item['delivery_status'] === "Pending" ? "selected" : ""}>Pending</option>
                                        <option value="Processing" ${item['delivery_status'] === "Processing" ? "selected" : ""}>Processing</option>
                                        <option value="Completed" ${item['delivery_status'] === "Completed" ? "selected" : ""}>Delivered</option>
                                        <option value="Return" ${item['delivery_status'] === "Return" ? "selected" : ""}>Return</option>
                                    </select>
                                </div>
                                <div class="modal-footer" style="text-align: right; border-top: 1px solid #ddd; padding-top: 10px;">
                                    <button 
                                        class="btn btn-success save-status-btn" 
                                        data-id="${item['id']}" 
                                        data-modal-id="${modalId}" 
                                        style="padding: 5px 10px;">
                                        Save
                                    </button>
                                </div>
                            </div>
                        </div>

                        </td>
                        <td>
                            <button data-id="${item['id']}" style="padding:5px; background-color:green; color:white; border-radius:5px;" class="DetailsBtn"><i class="fa fa-eye fa-xl"></i></button>
                        </td>
                </tr>`;
            
            tableList.append(row);

            // Event listener for modal open
            document.getElementById(buttonId).addEventListener("click", function () {
                document.getElementById(modalId).style.display = "block";
            });

            // Event listener for modal close
            document.querySelector(`#${modalId} .close`).addEventListener("click", function () {
                document.getElementById(modalId).style.display = "none";
            });
        });

        // Global click to close modals
        window.onclick = function (event) {
            if (event.target.classList.contains("modal")) {
                event.target.style.display = "none";
            }
        };

        $('.DetailsBtn').on('click', async function () {
            let id = $(this).data('id');
            console.log(id);
            window.location.href = `/order-details?id=${id}`; // Use backticks (`) instead of double quotes ("")
        });


        document.querySelectorAll('.save-status-btn').forEach(button => {
            button.addEventListener('click', async function () {
                const id = this.getAttribute('data-id');
                const modalId = this.getAttribute('data-modal-id');
                const dropdown = document.querySelector(`#delivery_status-${id}`);
                const selectedStatus = dropdown.value;

                if (selectedStatus === '') {
                    errorToast('Please select a delivery status.');
                    return;
                }

                try {
                    const response = await axios.post('/update-delivery-status', {
                        id: id,
                        delivery_status: selectedStatus,
                    });

                    if (response.data.success) {
                        successToast('Delivery status updated successfully!');
                        document.getElementById(modalId).style.display = "none";
                        getList(); // Refresh the table data
                    } else {
                        errorToast('Failed to update delivery status. Please try again.');
                    }
                } catch (error) {
                    console.error('Error updating delivery status:', error);
                    errorToast('An error occurred. Please try again later.');
                }
            });
        });


        // Initialize DataTable
        new DataTable('#tableData', {
            lengthMenu: [20, 30, 50, 100, 500]
        });

    } catch (error) {
        console.error("Error fetching invoice data:", error);
        hideLoader();
        errorToast("Failed to load invoice data. Please try again.");
    }
}

</script>
    