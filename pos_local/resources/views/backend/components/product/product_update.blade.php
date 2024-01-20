<div class="modal animated zoomIn" id="update-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Product Details</h5>
            </div>
            <div class="modal-body">
                <form id="update-form">
                    <div class="container">
                        <label class="form-label">Category</label>
                        <select type="text" class="form-control form-select" id="ProductCategoryUpdate">
                            <option value="">Select Category</option>
                        </select>

                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Product Name *</label>
                                <input type="text" class="form-control" id="ProductNameUpdate">

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Price*</label>
                                <input type="text" class="form-control" id="ProductPriceUpdate">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Unit *</label>
                                <input type="text" class="form-control" id="ProductUnitUpdate">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" id="ProductDescriptionUpdate" rows="2"></textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 p-1">
                                <br/>
                                <img class="w-15" id="oldImg" src="{{asset('images/default.jpg')}}"/>
                                <br/>
                                <label class="form-label mt-2">Image</label>
                                <input oninput="oldImg.src=window.URL.createObjectURL(this.files[0])"  type="file" class="form-control" id="productImgUpdate">

                                <input type="text" class="d-none" id="updateID">
                                <input type="text" class="d-none" id="filePath">


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

FillUpdateCategoryDropDown();

async function FillUpdateCategoryDropDown(selectedCategoryId) {


    let res = await axios.get("/CategoryList", HeaderToken())
    res.data.data.forEach(function(item, i) {
        let option = `<option value="${item['id']}" ${item['id'] === selectedCategoryId ? 'selected' : ''}>${item['name']}</option>`;
            $("#ProductCategoryUpdate").append(option);

    })
}


   async function FillUpUpdateForm(id,filePath){
       try {
        document.getElementById('updateID').value=id;
        document.getElementById('filePath').value=filePath;
        document.getElementById('oldImg').src=filePath;

           console.log(id);
           showLoader();
           let res=await axios.post("/ProductByID",{id:id},HeaderToken())
           hideLoader();
           document.getElementById('ProductNameUpdate').value=res.data['data']['name'];
           document.getElementById('ProductPriceUpdate').value=res.data['data']['price'];
           document.getElementById('ProductUnitUpdate').value=res.data['data']['unit'];
           document.getElementById('ProductDescriptionUpdate').value=res.data['data']['description'];

       }catch (e) {
           unauthorized(e.response.status)
       }
    }




    async function Update() {
    try {
        let ProductCategoryUpdate = document.getElementById('ProductCategoryUpdate').value;
        let ProductNameUpdate = document.getElementById('ProductNameUpdate').value;
        let ProductPriceUpdate = document.getElementById('ProductPriceUpdate').value;
        let ProductUnitUpdate = document.getElementById('ProductUnitUpdate').value;
        let ProductDescriptionUpdate = document.getElementById('ProductDescriptionUpdate').value;
        let updateID = document.getElementById('updateID').value;
        let filePath = document.getElementById('filePath').value;

        let productImgUpdate = document.getElementById('productImgUpdate').files[0];

        if (ProductCategoryUpdate.length === 0) {
            errorToast("Product Category Required !");
        } else if (ProductNameUpdate.length === 0) {
            errorToast("Product Name Required !");
        } else if (ProductPriceUpdate.length === 0) {
            errorToast("Product Price Required !");
        } else if (ProductUnitUpdate.length === 0) {
            errorToast("Product Unit Required !");
        } else {
            let formData = new FormData();
            formData.append('id', updateID);
            formData.append('category_id', ProductCategoryUpdate);
            formData.append('name', ProductNameUpdate);
            formData.append('price', ProductPriceUpdate); // Fix typo here
            formData.append('unit', ProductUnitUpdate);
            formData.append('description', ProductDescriptionUpdate);
            formData.append('old_file_path', filePath);
            formData.append('img_url', productImgUpdate);





            const config = {
                headers: {
                    'content-type': 'multipart/form-data',
                    'Authorization': getToken()
                }
            }

            showLoader();
            let res = await axios.post("/ProductUpdate", formData, config);
            console.log(res);
            hideLoader();

            if (res.data['status'] === "success") {
                document.getElementById("update-form").reset();
                document.getElementById('update-modal-close').click();
                successToast(res.data['message']);
                await getList();
            } else {
                errorToast(res.data['message']);
            }
        }
    } catch (e) {
        unauthorized(e.response.status);
    }
}


</script>


