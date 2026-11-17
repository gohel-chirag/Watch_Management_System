<?php
session_start();
include("assets/includes/db.php");

if(isset($_POST['register']))
{
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Check if email exists
    $checkEmail = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

    if(mysqli_num_rows($checkEmail) > 0)
    {
        $error = "Email already exists!";
    }
    else
    {
        // Check if phone exists
        $checkPhone = mysqli_query($conn, "SELECT * FROM users WHERE phone='$phone'");

        if(mysqli_num_rows($checkPhone) > 0)
        {
            $error = "Phone number already exists!";
        }
        else
        {
            $hashPassword = password_hash($password, PASSWORD_DEFAULT);

            $insert = mysqli_query($conn, "INSERT INTO users(name,email,phone,password)
            VALUES('$name','$email','$phone','$hashPassword')");

            if($insert)
            {
                $success = "Registration Successful.";
                echo "<script>
                    setTimeout(function(){
                        window.location='login.php';
                    },2000);
                </script>";
            }
            else
            {
                $error = "Registration Failed!";
            }
        }
    }
}
?>

<!-- Register Styles -->
<style>
    .register-page {
        min-height: 5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 0;
    }

    .register-page .row {
        width: 100%;
        margin: 0;
    }

    .register-page .card {
        width: 100%;
        max-width: 500px;
        margin: 0 auto;
        border: none;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    }

    .register-page h2 {
        font-family: 'Cinzel', serif;
        font-size: clamp(26px, 4vw, 34px);
        font-weight: 600;
        color: #111;
    }

    .register-page p {
        font-family: 'Cinzel', serif;
        color: #666;
    }

    .register-page .form-label {
        color: #111;
        font-weight: 500;
    }

    .register-page .form-control {
        width: 100%;
        height: 45px;
        border-radius: 10px;
        border: 1px solid #ddd;
        padding: 10px 15px;
        font-size: 15px;
    }

    .register-page .form-control:focus {
        border-color: #000;
        box-shadow: none;
    }

    .register-page .btn-dark {
        width: 100%;
        height: 45px;
        background: #000;
        border: 1px solid transparent;
        font-size: 16px;
    }

    .register-page .btn-dark:hover {
        background: #fff;
        color: #000;
        border: 1px solid #000;
    }

    .register-page .eye:hover{
        background-color: #9292927f;
    }

    .register-page a {
        color: #000;
        font-weight: 600;
    }

    @media(max-width:992px) {
        .register-page {
            padding: 30px 15px;
        }

        .register-page .card {
            max-width: 450px;
        }
    }

    @media(max-width:576px) {
        .register-page {
            padding: 20px 10px;
        }

        .register-page .card {
            max-width: 100%;
            padding: 20px 15px;
            border-radius: 15px;
        }

        .register-page h2 {
            font-size: 26px;
        }

        .register-page p {
            font-size: 14px;
        }

        .register-page .form-control {
            height: 42px;
            font-size: 14px;
        }

        .register-page .btn-dark {
            height: 42px;
            font-size: 15px;
        }
    }

    .custom-success{
        background: #ffffff;
        color: #198754;
        border: 1px solid #e0e0e0;
        border-left: 4px solid #198754;
        border-radius: 10px;
        padding: 12px 16px;
        margin: 15px 0;
        font-size: 15px;
        font-family: Arial, sans-serif;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        transition: 0.3s;
    }

    .custom-success:hover{
        box-shadow: 0 6px 16px rgba(0,0,0,0.12);
    }
</style>

<!-- Header Includes -->
<?php include 'assets/includes/header.php'; ?>

<!-- Register Section -->
<section class="container register-page">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-10 col-md-7 col-lg-5">
            <div class="card">
                <div class="text-center mb-4">
                    <h2>Create Account</h2>
                    <p class="text-muted">Register your account</p>
                </div>

                <?php if(isset($error)){ ?>
                    <div class="alert custom-alert text-center">
                        ⚠ <?php echo $error; ?>
                    </div>
                <?php } ?>

                <?php if(isset($success)){ ?>
                    <div class="alert custom-success text-center">
                        ✅ <?php echo $success; ?>
                    </div>
                <?php } ?>

                <form method="POST" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text"
                            name="name"
                            class="form-control"
                            placeholder="Enter your name"
                            maxlength="100"
                            required>
                        <div class="invalid-feedback" id="name-error">Please enter your name.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control"
                            placeholder="Enter your email" required>
                        <div class="invalid-feedback" id="email-error">Please enter a valid email.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="tel" name="phone" class="form-control"
                            placeholder="Enter phone number"
                            maxlength="10"
                            pattern="[0-9]{10}"
                            required>
                        <div class="invalid-feedback" id="phone-error">Please enter a valid 10-digit phone number.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password"
                                name="password"
                                id="passwordInput"
                                class="form-control"
                                placeholder="Enter password"
                                minlength="6"
                                required>
                            <button class="btn btn-outline-secondary eye" style="border-radius:0px 10px 10px 0px;" type="button" id="togglePassword">
                                <i class="bi bi-eye"></i>
                            </button>
                            <div class="invalid-feedback" id="password-error">Please enter your password.</div>
                        </div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" name="register" class="btn btn-dark rounded-pill">
                            Register
                        </button>
                    </div>

                    <p class="text-center mt-3 mb-0">
                        Already have account?
                        <a href="login.php" class="text-decoration-none">Login</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/script.js"></script>

<!-- Form Validation Script -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const form = document.querySelector("form");
        const nameInput = document.querySelector('input[name="name"]');
        const emailInput = document.querySelector('input[name="email"]');
        const phoneInput = document.querySelector('input[name="phone"]');
        const passwordInput = document.getElementById("passwordInput");

        const nameError = document.getElementById("name-error");
        const emailError = document.getElementById("email-error");
        const phoneError = document.getElementById("phone-error");
        const passwordError = document.getElementById("password-error");
        const togglePassword = document.getElementById("togglePassword");

        // Toggle Password Visibility
        if (togglePassword && passwordInput) {
            togglePassword.addEventListener("click", function () {
                const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
                passwordInput.setAttribute("type", type);
                
                this.innerHTML = type === "password" 
                    ? '<i class="bi bi-eye"></i>' 
                    : '<i class="bi bi-eye-slash"></i>';
            });
        }

        form.addEventListener("submit", function (e) {
            let isValid = true;

            // Validate Name
            const nameValue = nameInput.value.trim();
            nameInput.classList.remove("is-invalid", "is-valid");
            if (nameValue === "") {
                nameError.textContent = "Please enter your name.";
                nameInput.classList.add("is-invalid");
                isValid = false;
            } else {
                nameInput.classList.add("is-valid");
            }

            // Validate Email
            const emailValue = emailInput.value.trim();
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            emailInput.classList.remove("is-invalid", "is-valid");
            if (emailValue === "") {
                emailError.textContent = "Please enter your email.";
                emailInput.classList.add("is-invalid");
                isValid = false;
            } else if (!emailPattern.test(emailValue)) {
                emailError.textContent = "Please enter a valid email address.";
                emailInput.classList.add("is-invalid");
                isValid = false;
            } else {
                emailInput.classList.add("is-valid");
            }

            // Validate Phone (10 digits)
            const phoneValue = phoneInput.value.trim();
            const phonePattern = /^[0-9]{10}$/;
            phoneInput.classList.remove("is-invalid", "is-valid");
            if (phoneValue === "") {
                phoneError.textContent = "Please enter your phone number.";
                phoneInput.classList.add("is-invalid");
                isValid = false;
            } else if (!phonePattern.test(phoneValue)) {
                phoneError.textContent = "Please enter a valid 10-digit phone number.";
                phoneInput.classList.add("is-invalid");
                isValid = false;
            } else {
                phoneInput.classList.add("is-valid");
            }

            // Validate Password
            const passwordValue = passwordInput.value.trim();
            passwordInput.classList.remove("is-invalid", "is-valid");
            if (passwordValue === "") {
                passwordError.textContent = "Please enter your password.";
                passwordInput.classList.add("is-invalid");
                isValid = false;
            } else if (passwordValue.length < 6) {
                passwordError.textContent = "Password must be at least 6 characters.";
                passwordInput.classList.add("is-invalid");
                isValid = false;
            } else {
                passwordInput.classList.add("is-valid");
            }

            // Prevent form submission if invalid
            if (!isValid) {
                e.preventDefault();
            }
        });
    });
</script>