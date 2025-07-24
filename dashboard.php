<?php
session_start();

// Example simple auth check (customize as needed)
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

if (!isset($_SESSION['username'])) {
    header("Location: admin_panel.php");
    exit;
}

// You can fetch real data from database here, below are dummy placeholders

$totalUsers = 1234;
$activeSessions = 328;
$revenue = 45600;
$serverUptime = "99.9%";

$recentUsers = [
    ['name' => 'Jane Doe', 'email' => 'jane@example.com', 'role' => 'User', 'joined' => '2025-07-20'],
    ['name' => 'John Smith', 'email' => 'john@example.com', 'role' => 'Admin', 'joined' => '2025-07-19'],
    ['name' => 'Alice Johnson', 'email' => 'alice@example.com', 'role' => 'User', 'joined' => '2025-07-18'],
    ['name' => 'Bob Brown', 'email' => 'bob@example.com', 'role' => 'Moderator', 'joined' => '2025-07-15'],
];

$role = $_SESSION['role'];
?>

<h2>Welcome <?= htmlspecialchars($_SESSION['username']) ?>!</h2>

<?php if ($role == 'admin'): ?>
    <h3>Admin Panel</h3>
    <ul>
        <li><a href="admin_create_user.php">Create New User</a></li>
        <li><a href="admin_panel.php">Manage Users</a></li>
    </ul>
<?php else: ?>
    <h3>User Dashboard</h3>
    <p>This is your user panel.</p>
<?php endif; ?>
<a href="logout.php">Logout</a>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>RootBoost Dashboard</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />


  <style>
    body {
      min-height: 100vh;
      background-color: #f8f9fa;
      font-family: 'Poppins', sans-serif;
    }

    #sidebar {
      min-width: 250px;
      max-width: 250px;
      background-color: #212529;
      color: #fff;
      transition: all 0.3s;
      height: 100vh;
      position: fixed;
      top: 0;
      left: 0;
      overflow-y: auto;
      z-index: 1040;
    }

    #sidebar .nav-link {
      color: #adb5bd;
      padding: 1rem 1.5rem;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    #sidebar .nav-link:hover, #sidebar .nav-link.active {
      background-color: #0d6efd;
      color: white;
    }

    #sidebar .nav-link i {
      font-size: 18px;
    }

    #content {
      margin-left: 250px;
      padding: 20px;
      transition: margin-left 0.3s;
    }

    #top-navbar {
      background-color: #fff;
      box-shadow: 0 2px 6px rgb(0 0 0 / 0.1);
      height: 60px;
      padding: 0 20px;
      display: flex;
      align-items: center;
      justify-content: flex-end;
      position: fixed;
      top: 0;
      left: 250px;
      right: 0;
      z-index: 1030;
    }

    @media (max-width: 768px) {
      #sidebar {
        margin-left: -250px;
        position: fixed;
        height: 100vh;
        z-index: 1050;
      }

      #sidebar.active {
        margin-left: 0;
      }

      #content {
        margin-left: 0;
        padding-top: 80px;
      }

      #top-navbar {
        left: 0;
      }
    }

    .card-header {
      font-weight: 600;
      background-color: #0d6efd;
      color: white;
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <nav id="sidebar">
    <div class="p-3">
      <h4 class="text-center mb-4">RootBoost</h4>

      <ul class="nav flex-column">
        <li class="nav-item">
          <a href="dashboard.php" class="nav-link active"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        </li>
        <li class="nav-item">
          <a href="admin_panel.php" class="nav-link"><i class="fas fa-users"></i> Users</a>
        </li>
        <li class="nav-item">
          <a href="analytics.php" class="nav-link"><i class="fas fa-chart-line"></i> Analytics</a>
        </li>
        <li class="nav-item">
          <a href="settings.php" class="nav-link"><i class="fas fa-cogs"></i> Settings</a>
        </li>
        <li class="nav-item mt-auto">
          <a href="logout.php" class="nav-link text-danger"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </li>
      </ul>
    </div>
  </nav>

  <!-- Top Navbar -->
  <nav id="top-navbar">
    <div class="dropdown">
      <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
        <img src="./slide bar/dark.jpg" alt="user" width="40" height="40" class="rounded-circle me-2" />
        <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>
      </a>
      <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
        <li><a class="dropdown-item" href="./slide bar/dark.jpg">Profile</a></li>
        <li><a class="dropdown-item" href="#">Settings</a></li>
        <li><hr class="dropdown-divider"/></li>
        <li><a class="dropdown-item text-danger" href="logout.php">Logout</a></li>
      </ul>
    </div>
  </nav>

  <!-- Main Content -->
  <main id="content" class="pt-5">

    <div class="container-fluid">

      <!-- Page Title -->
      <h1 class="mb-4">Dashboard Overview</h1>

      <!-- Row of Cards -->
      <div class="row g-4 mb-4">

        <div class="col-md-3">
          <div class="card shadow-sm">
            <div class="card-header">Total Users</div>
            <div class="card-body">
              <h3><?php echo $totalUsers; ?></h3>
              <p class="text-success"><i class="fas fa-arrow-up"></i> 5.2% since last month</p>
            </div>
          </div>
        </div>

        <div class="col-md-3">
          <div class="card shadow-sm">
            <div class="card-header">Active Sessions</div>
            <div class="card-body">
              <h3><?php echo $activeSessions; ?></h3>
              <p class="text-danger"><i class="fas fa-arrow-down"></i> 1.3% since yesterday</p>
            </div>
          </div>
        </div>

        <div class="col-md-3">
          <div class="card shadow-sm">
            <div class="card-header">Revenue</div>
            <div class="card-body">
              <h3>$<?php echo number_format($revenue); ?></h3>
              <p class="text-success"><i class="fas fa-arrow-up"></i> 12% since last quarter</p>
            </div>
          </div>
        </div>

        <div class="col-md-3">
          <div class="card shadow-sm">
            <div class="card-header">Server Uptime</div>
            <div class="card-body">
              <h3><?php echo $serverUptime; ?></h3>
              <p class="text-success"><i class="fas fa-arrow-up"></i> Stable</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Analytics Section -->
      <div class="row">

        <!-- Recent Users Table -->
        <div class="col-lg-6 mb-4">
          <div class="card shadow-sm">
            <div class="card-header">Recent Users</div>
            <div class="card-body p-0">
              <table class="table mb-0">
                <thead class="table-light">
                  <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Joined</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($recentUsers as $user): ?>
                  <tr>
                    <td><?php echo htmlspecialchars($user['name']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><?php echo htmlspecialchars($user['role']); ?></td>
                    <td><?php echo htmlspecialchars($user['joined']); ?></td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

            <!-- User Activity Chart Module -->
            <div class="col-lg-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header">User Activity (Chart)</div>
                <div class="card-body">
                <canvas id="userActivityChart" style="min-height: 250px;"></canvas>
                </div>
            </div>
            </div>


            <!-- Chart.js CDN -->
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


            <div class="container mt-5">
                <div class="row justify-content-center">
                
                <!-- Calendar Card -->
                <div class="col-md-6">
                    <div class="card shadow-sm text-center p-4">
                    <div class="card-body d-flex flex-column align-items-center">
                        <!-- Calendar Icon -->
                        <i class="fas fa-calendar-alt fa-4x text-primary mb-3"></i>
                        
                        <!-- Date Display -->
                        <h5 class="card-title">Today's Date</h5>
                        <p id="current-date" class="fs-5 fw-bold text-dark">Loading...</p>
                    </div>
                    </div>
                </div>

                </div>
            </div>

            <!-- Bootstrap JS (optional) -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

            <!-- Dynamic Date Script -->
            <script>
                const dateElement = document.getElementById('current-date');
                const today = new Date();
                const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                dateElement.textContent = today.toLocaleDateString('en-GB', options); 
                // Format: Wednesday, 24 July 2025
            </script>

            <script>
            const ctx = document.getElementById('userActivityChart').getContext('2d');
            const userActivityChart = new Chart(ctx, {
                type: 'line', // You can change this to 'bar', 'pie', etc.
                data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'], // X-axis labels
                datasets: [{
                    label: 'Active Users',
                    data: [12, 19, 8, 15, 10, 5, 18], // Example placeholder data
                    fill: true,
                    borderColor: '#007bff',
                    backgroundColor: 'rgba(0, 123, 255, 0.1)',
                    tension: 0.4
                }]
                },
                options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Users'
                    }
                    },
                    x: {
                    title: {
                        display: true,
                        text: 'Day of Week'
                    }
                    }
                },
                plugins: {
                    legend: {
                    display: true
                    }
                }
                }
            });
            </script>


      </div>

    </div>
  </main>

  <!-- Bootstrap JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
