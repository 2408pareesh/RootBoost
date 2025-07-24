<?php
// Show errors during development
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// Simulate login for testing
if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 1; // fallback for testing
    // Optionally redirect here
    // header("Location: settings_dashboard.html");
    // exit;
}

$host = '127.0.0.1';
$db   = 'rootboost_db'; // Update if needed
$user = 'root';
$pass = '';
$dsn  = "mysql:host=$host;dbname=$db;charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

$userId = $_SESSION['user_id'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $twofa = isset($_POST['2fa']) ? 1 : 0;
    $notify = isset($_POST['notifications']) ? 1 : 0;
    $theme = $_POST['theme'] ?? 'dark';

    // Validate required fields
    if ($username && $email) {
        $sql = "UPDATE users 
                SET username = :username, 
                    email = :email, 
                    two_fa = :twofa, 
                    notifications = :notify, 
                    theme = :theme";

        if (!empty($password)) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $sql .= ", password = :password";
        }

        $sql .= " WHERE id = :id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':twofa', $twofa, PDO::PARAM_INT);
        $stmt->bindParam(':notify', $notify, PDO::PARAM_INT);
        $stmt->bindParam(':theme', $theme);
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);

        if (!empty($password)) {
            $stmt->bindParam(':password', $hashedPassword);
        }

        if ($stmt->execute()) {
            $success = "✅ Settings updated successfully!";
        } else {
            $error = "❌ Failed to update settings.";
        }
    } else {
        $error = "⚠️ Username and email are required.";
    }
}

// Fetch user info to show in form
$stmt = $pdo->prepare("SELECT username, email, two_fa, notifications, theme FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("⚠️ User not found. Make sure user ID $userId exists in database.");
}
?>

<!DOCTYPE html>
<html lang="en" class="<?= $user['theme'] === 'dark' ? 'bg-gray-900 text-white' : 'bg-white text-black' ?>">
<head>
  <meta charset="UTF-8">
  <title>Settings Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    function showTab(id) {
        document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
        document.getElementById(id).classList.remove('hidden');
    }
    window.onload = () => showTab('profile');
  </script>
</head>
<body class="flex min-h-screen">

<!-- Sidebar -->
<aside class="w-64 bg-gray-800 text-white p-6 space-y-4">
  <h2 class="text-2xl font-bold">Settings</h2>
  <nav class="space-y-2">
    <a href="dashboard.php" class="block py-2 px-2 rounded hover:bg-gray-700">← Back to Dashboard</a>
    <button onclick="showTab('profile')" class="block w-full text-left py-2 hover:bg-gray-700 rounded">Profile</button>
    <button onclick="showTab('security')" class="block w-full text-left py-2 hover:bg-gray-700 rounded">Security</button>
    <button onclick="showTab('notifications')" class="block w-full text-left py-2 hover:bg-gray-700 rounded">Notifications</button>
    <button onclick="showTab('appearance')" class="block w-full text-left py-2 hover:bg-gray-700 rounded">Appearance</button>
  </nav>
</aside>

<!-- Main Content -->
<main class="flex-1 p-10 space-y-6">
  <h1 class="text-3xl font-semibold mb-4">User Settings</h1>

  <?php if (isset($success)) : ?>
    <div class="p-4 bg-green-500 text-white rounded"><?= $success ?></div>
  <?php endif; ?>

  <form method="post" class="space-y-8">

    <!-- Profile -->
    <div id="profile" class="tab-content">
      <h2 class="text-xl font-bold mb-4">Profile Settings</h2>
      <div class="space-y-4">
        <div>
          <label class="block text-sm">Username</label>
          <input name="username" value="<?= htmlspecialchars($user['username']) ?>" required class="w-full p-2 bg-gray-700 rounded border border-gray-600">
        </div>
        <div>
          <label class="block text-sm">Email</label>
          <input name="email" type="email" value="<?= htmlspecialchars($user['email']) ?>" required class="w-full p-2 bg-gray-700 rounded border border-gray-600">
        </div>
      </div>
    </div>

    <!-- Security -->
    <div id="security" class="tab-content hidden">
      <h2 class="text-xl font-bold mb-4">Security</h2>
      <div class="space-y-4">
        <div>
          <label class="block text-sm">New Password</label>
          <input name="password" type="password" placeholder="Leave blank to keep unchanged" class="w-full p-2 bg-gray-700 rounded border border-gray-600">
        </div>
        <div class="flex items-center space-x-2">
          <input name="2fa" type="checkbox" <?= $user['two_fa'] ? 'checked' : '' ?> class="form-checkbox text-blue-500">
          <label>Enable Two-Factor Authentication</label>
        </div>
      </div>
    </div>

    <!-- Notifications -->
    <div id="notifications" class="tab-content hidden">
      <h2 class="text-xl font-bold mb-4">Notification Preferences</h2>
      <div class="flex items-center space-x-2">
        <input name="notifications" type="checkbox" <?= $user['notifications'] ? 'checked' : '' ?> class="form-checkbox text-blue-500">
        <label>Receive email notifications</label>
      </div>
    </div>

    <!-- Appearance -->
    <div id="appearance" class="tab-content hidden">
      <h2 class="text-xl font-bold mb-4">Appearance</h2>
      <div>
        <label class="block text-sm mb-2">Theme</label>
        <select name="theme" class="p-2 rounded bg-gray-700 border border-gray-600">
          <option value="dark" <?= $user['theme'] === 'dark' ? 'selected' : '' ?>>Dark</option>
          <option value="light" <?= $user['theme'] === 'light' ? 'selected' : '' ?>>Light</option>
        </select>
      </div>
    </div>

    <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">Save All Settings</button>
  </form>
</main>

</body>
</html>
