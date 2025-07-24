<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Root Login</title>
</head>
<body>

<form action="login.php" method="POST">
    <input type="text" name="username" placeholder="Username" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <button type="submit" name="submit">Login</button>

    <?php if (isset($_SESSION['error'])): ?>
        <p style="color: red;"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
    <?php endif; ?>
</form>

</body>
</html>

