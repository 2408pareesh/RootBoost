<?php
session_start();
date_default_timezone_set('Asia/Colombo');

// Email settings
$to = "yourmail@example.com"; // Replace with your email
$subject = "New Dashboard View from Customer";

// Get IP
$ip = $_SERVER['REMOTE_ADDR'] ?? 'Unknown';

// Get public IP if on localhost
if ($ip === "::1" || $ip === "127.0.0.1") {
    $publicIp = @file_get_contents('https://api.ipify.org');
    if ($publicIp && filter_var($publicIp, FILTER_VALIDATE_IP)) {
        $ip = $publicIp;
    }
}

// Default values
$location = "Unknown";
$latitude = 0;
$longitude = 0;

// IP Geolocation
$locationData = @file_get_contents("http://ip-api.com/json/{$ip}");
if ($locationData) {
    $locationInfo = json_decode($locationData, true);
    if ($locationInfo && $locationInfo['status'] === 'success') {
        $location = $locationInfo['city'] . ', ' . $locationInfo['country'];
        $latitude = $locationInfo['lat'];
        $longitude = $locationInfo['lon'];
    } else {
        $location = "Location not found";
    }
}

// Save to DB
try {
    $conn = new PDO("mysql:host=localhost;dbname=rootboost_db", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("INSERT INTO dashboard_views (ip_address, location, viewed_at) VALUES (?, ?, NOW())");
    $stmt->execute([$ip, $location]);
} catch (PDOException $e) {
    echo "DB error: " . $e->getMessage();
}

// Email notification
$message = "Customer viewed the dashboard.\n\nIP: $ip\nLocation: $location\nTime: " . date("Y-m-d H:i:s");
$headers = "From: notifier@rootboost.com";
@mail($to, $subject, $message, $headers);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Analytics</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <style>
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: Arial, sans-serif;
            color: #fff;
        }
        #map {
            position: fixed;
            top: 0; left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            filter: brightness(0.5);
        }
        .content {
            position: relative;
            z-index: 10;
            text-align: center;
            padding-top: 100px;
        }
        h1 {
            font-size: 3em;
        }
        .text-green {
            color: #7CFC00;
        }
    </style>
</head>
<body>

<div id="map"></div>

<div class="content">
    <h1>Customer Analytics</h1>
    <p><strong>Your IP:</strong> <?= htmlspecialchars($ip) ?></p>
    <p><strong>Location:</strong> <?= htmlspecialchars($location) ?></p>
    <p class="text-green">✔ Admin has been alerted by email.</p>
</div>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    const lat = <?= json_encode($latitude) ?>;
    const lon = <?= json_encode($longitude) ?>;

    const map = L.map('map').setView([lat, lon], 10);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    L.marker([lat, lon]).addTo(map)
        .bindPopup("You are approximately here: <?= htmlspecialchars($location) ?>")
        .openPopup();
</script>

</body>
</html>
