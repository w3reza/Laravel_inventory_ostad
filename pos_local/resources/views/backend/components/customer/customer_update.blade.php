<div class="modal animated zoomIn" id="update-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Customer Details</h5>
            </div>
            <div class="modal-body">
                <form id="update-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Customer Name *</label>
                                <input type="text" class="form-control" id="customerNameUpdate">
                                <input class="d-none" id="updateID">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Customer Email *</label>
                                <input type="text" class="form-control" id="customerEmailUpdate">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Customer Mobile *</label>
                                <input type="text" class="form-control" id="customerMobileUpdate">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Customer Address</label>
                                <textarea class="form-control" id="customerAddressUpdate" rows="2"></textarea>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="update-modal-close" class="btn bg-gradient-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                <button onclick="Update()" id="update-btn" class="btn bg-gradient-success" >Update</button>
            </div>
        </div>
    </div>
</div>


<script>


   async function FillUpUpdateForm(id){
       try {
           document.getElementById('updateID').value=id;
           console.log(id);
           showLoader();
           let res=await axios.post("/CustomerByID",{id:id},HeaderToken())
           hideLoader();
           document.getElementById('customerNameUpdate').value=res.data['data']['name'];
           document.getElementById('customerEmailUpdate').value=res.data['data']['email'];
           document.getElementById('customerMobileUpdate').value=res.data['data']['mobile'];
           document.getElementById('customerAddressUpdate').value=res.data['data']['address'];
       }catch (e) {
           unauthorized(e.response.status)
       }
    }




    async function Update() {

       try {


           let updateID = document.getElementById('updateID').value;

           let customerUpdateData = {
                id: updateID,
                name: document.getElementById('customerNameUpdate').value,
                email: document.getElementById('customerEmailUpdate').value,
                mobile: document.getElementById('customerMobileUpdate').value,
                address: document.getElementById('customerAddressUpdate').value,
            }


           showLoader();
           let res = await axios.post("/CustomerUpdate",customerUpdateData,HeaderToken())
           hideLoader();

           if(res.data['status']==="success"){
               document.getElementById("update-form").reset();
               document.getElementById('update-modal-close').click();
               successToast(res.data['message'])
               await getList();
           }
           else{
               errorToast(res.data['message'])
           }

       }catch (e) {
           unauthorized(e.response.status)
       }
    }



</script>
