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
            <div class="card p-4 m-3 text-center">
                <div class="card-body">
                    <div class="">
                        <h2>Login Form</h2>
                    </div>
                    <hr>
                    <form action="#">
                        <div class="form-group mb-3">
                            <input type="text" id="email" placeholder="Email Address" required class="form-control"/>
                        </div>
                        <div class="form-group mb-3">
                            <div class="password-wrapper">
                                <input id="password" placeholder="Password" class="form-control" type="password"
                                autofocus />
                                <span id="togglePassword" class="toggle-icon">👁️</span>
                            </div>
                        </div>
                    </form>
                    <button onclick="SubmitLogin()" class="login-btn btn btn-primary w-100">Next</button>
                    <div class="forgot-btn p-2 m-2"><a href="{{ url('/sendOtp') }}">Forgot password?</a></div>
                    <hr>
                    <div class="signup-link"> 
                        Not a member? <span><a href="{{ url('/registration') }}">Signup now</a></span> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    async function SubmitLogin() {
        let email = document.getElementById('email').value;
        let password = document.getElementById('password').value;

        if (email.length === 0) {
            errorToast("Email is required");
        } else if (password.length === 0) {
            errorToast("Password is required");
        } else {
            showLoader();
            let res = await axios.post("/user-login", {
                email: email,
                password: password
            });
            hideLoader()
            if (res.status === 200 && res.data['status'] === 'success') {
                const userRole = res.data['data'];

                if (userRole === 'admin') {
                    // Redirect admins to dashboard
                    window.location.href = "/dashboard";
                } else if (userRole === 'customer') {
                    // Retrieve the last location
                    const lastLocation = sessionStorage.getItem("last_location");

                    if (lastLocation) {
                        console.log("Redirecting to last location:", lastLocation);
                        sessionStorage.removeItem("last_location"); // Clear after using
                        window.location.href = lastLocation;
                    } else {
                        console.log("No last location found. Redirecting to home.");
                        window.location.href = "/";
                    }
                } else {
                    // Handle unexpected roles
                    errorToast("Invalid user role. Please contact support.");
                }
            } else {
                // Show error message from response
                errorToast(res.data['message'] || "An error occurred. Please try again.");
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