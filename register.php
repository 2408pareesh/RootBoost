<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Register | RootBoost</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>

  <!-- Custom Style -->
  <style>
    body {
      background: linear-gradient(135deg, #1d2b64, #f8cdda);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Poppins', sans-serif;
    }

    .register-box {
      background: rgba(255, 255, 255, 0.1);
      padding: 2.5rem;
      border-radius: 15px;
      box-shadow: 0 8px 30px rgba(0,0,0,0.3);
      width: 100%;
      max-width: 500px;
      color: white;
    }

    .form-control {
      background-color: rgba(255,255,255,0.2);
      border: none;
      color: white;
    }

    .form-control::placeholder {
      color: #ccc;
    }

    .form-control:focus {
      background-color: rgba(255,255,255,0.3);
      color: white;
      box-shadow: none;
    }

    .btn-custom {
      margin-top: 15px;
      width: 100%;
    }

    .form-label i {
      margin-right: 6px;
    }

    .back-link {
      color: #ffc107;
      text-decoration: none;
    }

    .back-link:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

  <div class="register-box">
    <h2 class="text-center mb-4">Create Account</h2>

    <form method="POST" action="process_register.php">
      <div class="mb-3">
        <label class="form-label"><i class="fas fa-user"></i>Full Name</label>
        <input type="text" class="form-control" name="fullname" placeholder="Your full name" required />
      </div>

      <div class="mb-3">
        <label class="form-label"><i class="fas fa-envelope"></i>Email</label>
        <input type="email" class="form-control" name="email" placeholder="you@example.com" required />
      </div>

      <div class="mb-3">
        <label class="form-label"><i class="fas fa-user-circle"></i>Username</label>
        <input type="text" class="form-control" name="username" placeholder="Choose a username" required />
      </div>

      <div class="mb-3">
        <label class="form-label"><i class="fas fa-lock"></i>Password</label>
        <input type="password" class="form-control" name="password" placeholder="Enter password" required />
      </div>

      <div class="mb-3">
        <label class="form-label"><i class="fas fa-lock"></i>Confirm Password</label>
        <input type="password" class="form-control" name="confirm_password" placeholder="Re-enter password" required />
      </div>

      <button type="submit" class="btn btn-success btn-custom">
        <i class="fas fa-user-plus me-2"></i>Register
      </button>

      <div class="text-center mt-3">
        <a href="index.php" class="back-link"><i class="fas fa-arrow-left"></i> Back to Home</a>
      </div>
    </form>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
