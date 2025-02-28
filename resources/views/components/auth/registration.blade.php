<style>
    @media only screen and (max-width: 600px) {
       .card{
           padding: 2px !important;
           margin: 2px !important;
       }
   }
</style>
<style>
    body {
        font: 14px sans-serif;
    }

    .wrapper {
        width: 360px;
        padding: 20px;
    }

    .form-group {
        margin-bottom: 1rem;
    }

    input.form-control {
        padding: 14px;
    }
    .password-wrapper {
        position: relative;
        /* display: inline-block; */
    }
    .toggle-icon {
        position: absolute;
        right: 18px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
    }
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card p-3 m-3 text-center">
                
                <div class="card-body">
                    <div class="">
                        <h2>Registration Form</h2>
                    </div>
                    <hr>
                    <form action="#">
                        <div class="form-group p-2">
                            <input type="text" id="firstName" class="form-control" placeholder="First Name">
                        </div>
                        <div class="form-group p-2">
                            <input type="text" id="lastName" class="form-control" placeholder="Last Name">
                        </div>
                        <div class="form-group p-2">
                            <input type="text" id="email" class="form-control" placeholder="Email">
                        </div>
                        <div class="form-group p-2">
                            <input type="text" id="mobile" class="form-control" placeholder="Phone number">
                        </div>
                        <div class="form-group p-2">
                            <div class="password-wrapper">
                                <input id="password" placeholder="Password" class="form-control" type="password"
                                autofocus />
                                <span id="togglePassword" class="toggle-icon">👁️</span>
                            </div>
                        </div>
                        <div class="check" style="display: flex; align-items: center; margin: 10px 0;">
                            <input class="form-check-input" id="condition" type="checkbox" value=""
                                style="margin-right: 10px; width:20px;">
                            <label class="form-check-label" for="condition"
                                style="font-size: 14px; color: rgb(55, 53, 128) 53, 112) 53, 112) 50, 117) 51, 51) 51, 51) 51, 51) 51, 51);">
                                I accept all terms & condition
                            </label>
                        </div>

                        <button onclick="onRegistration()" class="login-btn btn mt-3 w-100  bg-success text-white">Sign Up</button>
                    </form>
                    <hr>
                    <div class="signup-link">Already have an account? <span><a href="{{ url('/login') }}">Login now</a></span> </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    async function onRegistration() {
        let firstName = document.getElementById('firstName').value.trim();
        let lastName = document.getElementById('lastName').value.trim();
        let email = document.getElementById('email').value.trim();
        let mobile = document.getElementById('mobile').value.trim();
        let password = document.getElementById('password').value.trim();
        let condition = document.getElementById('condition').checked;

        if (email === "") {
            errorToast('Email is required');
        } else if (firstName === "") {
            errorToast('First Name is required');
        } else if (lastName === "") {
            errorToast('Last Name is required');
        } else if (mobile === "") {
            errorToast('Mobile is required');
        } else if (password === "") {
            errorToast('Password is required');
        } else if (!condition) {
            errorToast('Please accept the terms & conditions.');
        } else {
            try {
                let button = document.querySelector('button');
                button.disabled = true;

                let res = await axios.post("/user-registration", {
                    firstName: firstName,
                    lastName: lastName,
                    email: email,
                    mobile: mobile,
                    password: password
                });

                button.disabled = false;

                if (res.status === 200 && res.data['status'] === 'success') {
                    alert(res.data['message']);
                    setTimeout(() => window.location.href = '/login', 2000);
                } else {
                    alert(res.data['message']);
                }
            } catch (error) {
                alert('Something went wrong. Please try again later.');
            }
        }
    }
</script>
<script>
    // Get password input and toggle icon
    const passwordInput = document.getElementById('password');
    const togglePassword = document.getElementById('togglePassword');

    // Add click event to toggle icon
    togglePassword.addEventListener('click', function () {
        // Toggle password visibility
        const type = passwordInput.type === 'password' ? 'text' : 'password';
        passwordInput.type = type;

        // Change icon (optional)
        this.textContent = type === 'password' ? '👁️' : '🙈';
    });
</script>