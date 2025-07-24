<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RootBoost | Home</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom Styles -->
    <style>
        body {
            background: linear-gradient(135deg, #1d2b64, #f8cdda);
            background-size: cover;
            min-height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Poppins', sans-serif;
            color: white;
        }

        .container-box {
            background: rgba(0, 0, 0, 0.6);
            padding: 3rem;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            text-align: center;
            max-width: 500px;
            width: 100%;
        }

        .btn-custom {
            margin: 10px 0;
            width: 100%;
        }

        h1 {
            font-weight: bold;
            margin-bottom: 20px;
        }

        .fa-logo {
            font-size: 3rem;
            margin-bottom: 15px;
            color: #ffc107;
        }
    </style>
</head>
<body>

    <div class="container-box">
        <div class="fa-logo">
            <i class="fas fa-bolt"></i>
        </div>
        <h1>Welcome to RootBoost</h1>
        <p class="lead">Your secure and stylish login system.</p>
        
        <a href="admin_panel.php" class="btn btn-primary btn-custom">
            <i class="fas fa-sign-in-alt me-2"></i>Login
        </a>
        <a href="register.php" class="btn btn-success btn-custom">
            <i class="fas fa-user-plus me-2"></i>Register
        </a>
        
        <a href="http://localhost/RootBoost/index.html" class="btn btn-warning w-100 mt-3">Back to home</a>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>


