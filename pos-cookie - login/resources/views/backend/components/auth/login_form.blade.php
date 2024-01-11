<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 animated fadeIn col-lg-6 center-screen">
            <div class="card w-90  p-4">
                <div class="card-body">
                    <h4>SIGN IN</h4>
                    <br />
                    <input id="email" placeholder="User Email" class="form-control" type="email" />
                    <br />
                    <input id="password" placeholder="User Password" class="form-control" type="password" />
                    <br />
                    <button onclick="SubmitLogin()" class="btn w-100 bg-gradient-primary">Next</button>
                    <hr />
                    <div class="float-end mt-3">
                        <span>
                            <a class="text-center ms-3 h6" href="{{ url('/registration') }}">Sign Up </a>
                            <span class="ms-1">|</span>
                            <a class="text-center ms-3 h6" href="{{ url('/send_otp') }}">Forget Password</a>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

if (cookieExists("token")) {
    // Redirect to another page
    window.location.href = "/userProfile";
}



    async function SubmitLogin() {
        try {
            let postBody = {
                email: document.getElementById('email').value,
                password: document.getElementById('password').value,
            };

            showLoader();
            let response = await axios.post('/user_login', postBody);
            hideLoader();

            if (response.status === 200 && response.data['status'] === 'success') {
                setToken(response.data['token']);
                successToast(response.data.message);
                setTimeout(() => {
                    window.location.href = "/userProfile";
                }, 1000);
            } else {
                errorToast(response.data.message);
            }
        } catch (e) {
            hideLoader();
            errorToast('Something went wrong!');
        }
    }


</script>
