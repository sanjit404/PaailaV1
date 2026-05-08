<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'child') {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head><title>Child Tracker</title></head>
<body>
<p style="color: red; font-size: small; background-color: rgba(235, 231, 231, 0.814);
 max-width: fit-content;">Warning: This page is accessing your location.</p>
 
 <a href="logout.php">🚪 Logout</a>

<script>
function sendLocationToServer() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
      function(position) {
        console.log("Got location:", position.coords.latitude, position.coords.longitude);

        fetch("update_location.php", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({
            latitude: position.coords.latitude,
            longitude: position.coords.longitude
          })
        })
        .then(res => res.json())
        .then(data => console.log("Server response:", data))
        .catch(err => console.error("Fetch error:", err));
      },
      function(error) {
        console.error("Geolocation error:", error);
      }
    );
  } else {
    console.error("Geolocation is not supported by this browser.");
  }
}

setInterval(sendLocationToServer, 10000);
sendLocationToServer(); // call once initially
</script>
</body>
</html>
