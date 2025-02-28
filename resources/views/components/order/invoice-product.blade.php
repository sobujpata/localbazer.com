<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content" >
        <div class="modal-header w-100">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Invoice Products</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>
        </div>
        <div class="modal-body w-100" id="invoice">
          <span id="productList"></span>
          <div class="modal-footer w-100 px-md-5">
            Total Price : <span id="total"></span>
          </div>
        </div>
        
        <div class="modal-footer w-100">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button onclick="PrintPage()" type="button" class="btn btn-primary">Print</button>
        </div>
      </div>
    </div>
  </div>

<script>
   async function InvoiceProductsPage(id,total){
        document.getElementById('total').innerHTML=total;
        showLoader();
        let res=await axios.post("/invoice-by-id",{id:id})
        hideLoader();

        console.log(res)
        let productList=$("#productList");
    
        productList.empty();
        res.data.forEach(function (item,index) {
            
            let div = `
                     <div class="row mb-2">
                        <div class="col-2">
                          <img src="${item['products']['image']}" class="img w-100 rounded-2" alt="">
                        </div>
                        <div class="col-10">
                          <div class="row">
                            <div class="col-md-6">
                              <p>${item['products']['title']}</p>
                            </div>
                            <div class="col-md-6">
                              <div class="row">
                                <div class="col-5">
                                  Qty : ${item['qty']}
                                </div>
                                <div class="col-7">
                                  Price : ${item['sale_price']}
                                </div>
                              </div>
                            </div>
                          </div>
                          
                        </div>
                      </div>
                     `
            productList.append(div)
        })
    }
    function PrintPage() {
        let printContents = document.getElementById('invoice').innerHTML;
        let originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        setTimeout(function() {
            location.reload();
        }, 1000);
    }

</script>
