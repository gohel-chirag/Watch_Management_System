<?php
  require_once "assets/includes/config.php";
  require_once "assets/includes/db.php";

  if(isset($_POST['login']))
  {
      $email = mysqli_real_escape_string($conn, $_POST['email']);
      $password = $_POST['password'];

      // Admin Login
      $adminQuery = mysqli_query($conn, "SELECT * FROM admin WHERE email='$email'");

      if(mysqli_num_rows($adminQuery) == 1)
      {
          $admin = mysqli_fetch_assoc($adminQuery);

          if($password == $admin['password'])   // Admin password is not hashed
          {
              $_SESSION['admin_id'] = $admin['admin_id'];
              $_SESSION['name'] = $admin['name'];
              $_SESSION['email'] = $admin['email'];

              header("Location: admin/dashboard.php");
              exit();
          }
      }

      // User Login
      $userQuery = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

      if(mysqli_num_rows($userQuery) == 1)
      {
          $user = mysqli_fetch_assoc($userQuery);

          if(password_verify($password, $user['password']))
          {
              $_SESSION['user_id'] = $user['id'];
              $_SESSION['user_name'] = $user['name'];
              $_SESSION['user_email'] = $user['email'];

              header("Location: index.php");
              exit();
          }
      }
      $error = "Invalid Email or Password!";
  }
?>

<!-- Login CSS -->
<style>
  .login-page {
    min-height: 5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px 0;
  }
  .login-page .row {
    width: 100%;
    margin: 0;
  }
  .login-page .card {
    width: 100%;
    max-width: 500px;
    margin: 0 auto;
    border: none;
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
  }
  .login-page h2 {
    font-family: "Cinzel", serif;
    font-size: clamp(26px, 4vw, 34px);
    font-weight: 600;
    color: #111;
  }
  .login-page p {
    font-family: "Cinzel", serif;
    color: #666;
  }
  .login-page .form-label {
    color: #111;
    font-weight: 500;
  }
  .login-page .form-control {
    width: 100%;
    height: 45px;
    border-radius: 10px;
    border: 1px solid #ddd;
    padding: 10px 15px;
    font-size: 15px;
  }
  .login-page .form-control:focus {
    border-color: #000;
    box-shadow: none;
  }
  .login-page .btn-dark {
    width: 100%;
    height: 45px;
    background: #000;
    border: 1px solid transparent;
    font-size: 16px;
  }
  .login-page .btn-dark:hover {
    background: #fff;
    color: #000;
    border: 1px solid #000;
  }
  .login-page a {
    color: #000;
    font-weight: 600;
  }
  .login-page .form-check-label {
    color: #666;
    font-size: 14px;
  }
  .login-page .eye:hover {
    background-color: #9292927f;
  }
  @media (max-width: 992px) {
    .login-page {
      padding: 30px 15px;
    }
    .login-page .card {
      max-width: 450px;
    }
  }
  @media (max-width: 576px) {
    .login-page {
      padding: 20px 10px;
    }
    .login-page .card {
      max-width: 100%;
      padding: 20px 15px;
      border-radius: 15px;
    }
    .login-page h2 {
      font-size: 26px;
    }
    .login-page p {
      font-size: 14px;
    }
    .login-page .form-control {
      height: 42px;
      font-size: 14px;
    }
    .login-page .btn-dark {
      height: 42px;
      font-size: 15px;
    }
  }
  /* Premium Minimal Error Alert */
  .custom-alert {
      background: #ffffff;
      color: #d93025;
      border: 1px solid #e0e0e0;
      border-left: 4px solid #d93025;
      border-radius: 10px;
      padding: 12px 16px;
      margin: 15px 0;
      font-size: 15px;
      font-family: Arial, sans-serif;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
      transition: 0.3s;
  }
  .custom-alert:hover {
      box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
  }
</style>

<!-- Header -->
<?php include 'assets/includes/header.php'; ?>

<!-- Login Section -->
<section class="container login-page">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-10 col-md-7 col-lg-5">
            <div class="card">
                <div class="text-center mb-4">
                    <h2>Welcome Back</h2>
                    <p class="text-muted">Login to your account</p>
                </div>

                <?php if(isset($error)){ ?>
                    <div class="alert custom-alert text-center">
                      ⚠ <?php echo $error; ?>
                    </div>
                <?php } ?>

                <form method="POST" class="needs-validation" novalidate>
                  <div class="mb-3">
                      <label class="form-label">Email</label>
                      <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                      <div class="invalid-feedback" id="email-error">Please enter a valid email.</div>
                  </div>

                  <div class="mb-3">
                    <label class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" name="password" id="passwordInput" class="form-control" placeholder="Enter password" required>
                        <button class="btn btn-outline-secondary eye" style="border-radius:0px 10px 10px 0px;" type="button" id="togglePassword"><i class="bi bi-eye"></i></button>
                    </div>
                    <div class="invalid-feedback" id="password-error">Please enter your password.</div>
                  </div>

                  <div class="d-grid">
                      <button type="submit" name="login" class="btn btn-dark rounded-pill">Login</button>
                  </div>

                  <p class="text-center mt-3 mb-0">
                      Don't have an account?
                      <a href="register.php" class="text-decoration-none">Create Account</a>
                  </p>
              </form>
            </div>
        </div>
    </div>
</section>

<!-- JS Form Validation -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");
    const emailInput = document.querySelector('input[name="email"]');
    const passwordInput = document.querySelector('input[name="password"]');

    const emailError = document.getElementById("email-error");
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

    // Form Submit Validation
    form.addEventListener("submit", function (e) {
        let isValid = true;

        // Email validation
        const emailValue = emailInput.value.trim();
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        emailInput.classList.remove("is-invalid", "is-valid");

        if (emailValue === "") {
            emailError.textContent = "Please enter your email.";
            emailInput.classList.add("is-invalid");
            isValid = false;
        } else if (!emailPattern.test(emailValue)) {
            emailError.textContent = "Please enter a valid email.";
            emailInput.classList.add("is-invalid");
            isValid = false;
        } else {
            emailInput.classList.add("is-valid");
        }

        // Password validation
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

        // Prevent submission if invalid
        if (!isValid) {
            e.preventDefault();
        }
    });
});
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/script.js"></script>