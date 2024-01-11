<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6 center-screen">
            <div class="card animated fadeIn w-90  p-4">
                <div class="card-body">
                    <h4>EMAIL ADDRESS</h4>
                    <br/>
                    <label>Your email address</label>
                    <input id="email" placeholder="User Email" class="form-control" type="email"/>
                    <br/>
                    <button onclick="SentOTP()"  class="btn w-100 float-end bg-gradient-primary">Next</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
async function SentOTP(){
    try{
        let postBody={
            email:document.getElementById('email').value,
        };
        showLoader();
        let response=await axios.post('/SendOTP',postBody);
        hideLoader();
        if(response.status===200 && response.data['status']==='success'){
            sessionStorage.setItem('email',document.getElementById('email').value);
            successToast(response.data.message);
            setTimeout(() => {
                window.location.href = "/verify_otp";
            }, 1000);
        } else {
            errorToast(response.data.message);
        }
    }catch (e) {
        hideLoader();
        errorToast('Something went wrong!');
    }
}
</script>
