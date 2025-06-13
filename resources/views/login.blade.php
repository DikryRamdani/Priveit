<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Form Login Privefit</title>
    <link
      href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="css/login.css" />
  </head>
  <body>
    <div class="container">
      <div class="form-box .login">
        <form action="{{ route('login') }}" method="POST">
          @csrf
          <h1>Login</h1>
          <div class="input-box">
            <input type="text" placeholder="Username" name="username" required />
            <i class="bx bxs-user"></i>
          </div>
          <div class="input-box">
            <input type="text" placeholder="Password" name="password" required />
            <i class="bx bxs-lock"></i>
          </div>
          <div class="forgot-link">
            <a href="#">Forgot Password</a>
          </div>
          <button type="submit" class="btn">Login</button>
          <p>or login with social media</p>
          <div class="social-icons">
            <a href="#"><i class="bx bxl-google"></i></a>
            <a href="#"><i class="bx bxl-github"></i></a>
            <a href="#"><i class="bx bxl-linkedin"></i></a>
          </div>
        </form>
      </div>
      <div class="form-box register">
        <form action="{{ route('register') }}" method="POST">
          @csrf
          <h1>Registration</h1>
          <div class="input-box">
            <input type="email" placeholder="Email" name="email" required />
            <i class="bx bx-envelope"></i>
          </div>
          <div class="input-box">
            <input type="text" placeholder="Username" name="username" required />
            <i class="bx bxs-user"></i>
          </div>
          <div class="input-box">
            <input type="passwordt" placeholder="Password" name="password" required />
            <i class="bx bxs-lock"></i>
          </div>
          <button type="submit" class="btn">Register</button>
          <p>or regist with social media</p>
          <div class="social-icons">
            <a href="#"><i class="bx bxl-google"></i></a>
            <a href="#"><i class="bx bxl-github"></i></a>
            <a href="#"><i class="bx bxl-linkedin"></i></a>
          </div>
        </form>
      </div>
      <div class="toggle-box">
        <div class="toggle-panel toggle-left">
          <h1>Hello, Welcome</h1>
          <p>Don't have an account?</p>
          <button class="btn regist-btn">Register</button>
        </div>
        <div class="toggle-panel toggle-right">
          <h1>Welcome Back!</h1>
          <p>Already have an account?</p>
          <button class="btn login-btn">Login</button>
        </div>
      </div>
    </div>
    <script src="js/login.js"></script>
  </body>
</html>
