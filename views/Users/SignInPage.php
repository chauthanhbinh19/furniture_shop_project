<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sign In</title>
  <link rel="stylesheet" href="../public/css/coreui.min.css">
</head>
<body class="bg-light d-flex align-items-center min-vh-100">
  <div class="container">
    <div class="d-flex justify-content-center">
      <div class="card p-4 shadow-lg rounded-4 my-5 w-100" style="max-width: 380px;">
        <h2 class="text-center mb-4">Sign In</h2>
        <form method="POST" action="UsersController.php?action=signin" novalidate>
          <div class="mb-3">
            <label class="form-label">Username or Email</label>
            <input type="text" name="identifier" class="form-control"
                   required minlength="4" maxlength="100"
                   pattern="^[a-zA-Z0-9@._-]+$"
                   title="Username hoặc Email không hợp lệ.">
          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control"
                   required minlength="6"
                   title="Mật khẩu phải có ít nhất 6 ký tự.">
          </div>
          <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
        <div class="text-center mt-3">
          Don't have an account? <a href="/signup">Sign Up</a>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
