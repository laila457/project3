<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login & Register</title>
    <!-- Bootstrap CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet" />
    <!-- Custom CSS -->
    <style>
      body {
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: white;
        background-image: url(logoo.jpeg);
        background-size: 150px;
      }
      .auth-container {
        max-width: 400px;
        width: 100%;
        padding: 30px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        background-color: #c86cc8;
      }
      .form-toggle {
        cursor: pointer;
        color: #7d24a0;
      }
      .form-toggle:hover {
        text-decoration: underline;
      }

      .login-image {
        width: 100%;
        max-width: 200px;
        height: auto;
        display: block;
        margin: 0 auto 0;
      }

      h2 {
        font-family: "Times New Roman", Times, serif;
        font-size: 20px;
      }

      h3 {
        font-family: "Times New Roman", Times, serif;
        font-size: 15px;
      }
      /* Custom button styles */
      .btn-purple {
        background-color: white; /* Warna ungu */
        border-color: white;
        color: rgb(15, 15, 15);
      }
      .btn-purple:hover {
        background-color: #8206b3; /* Warna ungu lebih gelap saat hover */
        border-color: #8206b3;
      }
    </style>
  </head>
  <body>
    <!-- Login Form -->
    <div class="auth-container" id="loginForm">
      <img src="<?=base_url();?>assets/image/logooo.png" alt="Login Image" class="login-image" />
      <h2 class="text-center mb-4">Woof woof!</h2>
      <h3 class="text-center mb-4">
        Woof woof! Welcome to Happy Paws, your pets ultimate happy place!!
      </h3>
      <form onsubmit="handleLogin(event)">
        <div class="mb-3">
        <label for="loginUsername" class="form-label">Username</label>
        <input type="text" class="form-control" id="loginUsername" placeholder="Username" required>
        </div>
        <div class="mb-3">
        <label for="loginPassword" class="form-label">Password</label>
        <input type="password" class="form-control" id="loginPassword" placeholder="Password" required>
        </div>
        <div class="mb-3 form-check">
          <input type="checkbox" class="form-check-input" id="rememberMe" />
          <label class="form-check-label" for="rememberMe">Remember me</label>
        </div>
        <button type="submit" class="btn btn-purple w-100">Login</button>
        <p class="text-center mt-3">
          Don't have an account?
          <span class="form-toggle" onclick="toggleForm()">Register here</span>
        </p>
      </form>
    </div>

    <!-- Register Form -->
    <div class="auth-container" id="registerForm" style="display: none">
      <h2 class="text-center mb-4">Register</h2>
      <form onsubmit="handleRegister(event)">
        <div class="mb-3">
        <label for="registerUsername" class="form-label">Username</label>
        <input type="text" class="form-control" id="registerUsername" placeholder="Username" required>
      </div>
      <div class="mb-3">
        <label for="registerEmail" class="form-label">Email address</label>
        <input type="email" class="form-control" id="registerEmail" placeholder="Email" required>
      </div>
      <div class="mb-3">
        <label for="registerPassword" class="form-label">Password</label>
        <input type="password" class="form-control" id="registerPassword" placeholder="Password" required>
      </div>
        <button type="submit" class="btn btn-purple w-100">Register</button>
        <p class="text-center mt-3">
          Already have an account?
          <span class="form-toggle" onclick="toggleForm()">Login here</span>
        </p>
      </form>
    </div>
    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <!-- Custom JavaScript -->
    <script src="script.js"></script>
  </body>
</html>
