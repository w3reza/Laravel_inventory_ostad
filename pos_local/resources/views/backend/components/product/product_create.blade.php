<div class="modal animated zoomIn" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">Product Create</h6>
            </div>
            <div class="modal-body">
                <form id="save-form">
                    <div class="container">


                        <label class="form-label">Category</label>
                                <select type="text" class="form-control form-select" id="ProductCategory">
                                    <option value="">Select Category</option>
                                </select>



                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Product Name *</label>
                                <input type="text" class="form-control" id="ProductName">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Price *</label>
                                <input type="text" class="form-control" id="ProductPrice">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Unit *</label>
                                <input type="text" class="form-control" id="ProductUnit">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Product Description</label>
                                <textarea class="form-control" id="ProductDescription" rows="1"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 p-1">
                                <br />
                                <img class="w-15" id="newImg" src="{{ asset('images/default.jpg') }}" />
                                <br />

                                <label class="form-label">Image</label>
                                <input oninput="newImg.src=window.URL.createObjectURL(this.files[0])" type="file"
                                    class="form-control" id="ProductImg">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="modal-close" class="btn bg-gradient-primary" data-bs-dismiss="modal"
                    aria-label="Close">Close</button>
                <button onclick="Save()" id="save-btn" class="btn bg-gradient-success">Save</button>
            </div>
        </div>
    </div>
</div>



<script>
    FillCategoryDropDown();

    async function FillCategoryDropDown() {
        let res = await axios.get("/CategoryList", HeaderToken())
        res.data.data.forEach(function(item, i) {
            let option = `<option value="${item['id']}">${item['name']}</option>`
            $("#ProductCategory").append(option);
        })
    }
    async function Save() {
        try {
            let ProductCategory = document.getElementById('ProductCategory').value;
            let ProductName = document.getElementById('ProductName').value;
            let ProductPrice = document.getElementById('ProductPrice').value;
            let ProductUnit = document.getElementById('ProductUnit').value;
            let ProductDescription = document.getElementById('ProductDescription').value;
            let ProductImg = document.getElementById('ProductImg').files[0];
            if (ProductCategory.length === 0) {
                errorToast("Product Category Required !")
            } else if (ProductName.length === 0) {
                errorToast("Product Name Required !")
            } else if (ProductPrice.length === 0) {
                errorToast("Product Price Required !")
            } else if (ProductUnit.length === 0) {
                errorToast("Product Unit Required !")
            } else if (!ProductImg) {
                errorToast("Product Image Required !")
            } else {


            let formData=new FormData();
            formData.append('category_id',ProductCategory)
            formData.append('name',ProductName)
            formData.append('price',ProductPrice)
            formData.append('unit',ProductUnit)
            formData.append('description',ProductDescription)
            formData.append('img_url',ProductImg)

            // Why is code is not working?
            let ProductData ={
                category_id:ProductCategory,
                name:ProductName,
                price:ProductPrice,
                unit:ProductUnit,
                description:ProductDescription,
                img_url:ProductImg
            }

                const config = {
                    headers: {
                        'content-type': 'multipart/form-data',
                       'Authorization': getToken()
                    }
                }
                showLoader();
            let res = await axios.post("/ProductCreate", formData,config)
            hideLoader();

            if (res.data['status'] === "success") {
                document.getElementById("save-form").reset();
                document.getElementById('modal-close').click();
                successToast(res.data['message']);
                await getList();
            } else {
                errorToast(res.data['message'])
            }
            }



        } catch (e) {

            unauthorized(e.response.status)
        }



    }

    $('#modal-close').click(function() {
        document.getElementById("save-form").reset();
    })
</script>
