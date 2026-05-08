<?php
session_start();
$isLoggedIn = isset($_SESSION['user']) ? true : false;
$userData = $isLoggedIn ? $_SESSION['user'] : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Paaila Tracking</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- React build CSS -->
  <link rel="stylesheet" href="/dist/assets/index.css" />
</head>
<body>
  <div id="root"></div>

  <!-- Inject PHP session into JS -->
  <script>
    window.userLoggedIn = <?= $isLoggedIn ? 'true' : 'false' ?>;
    window.userData = <?= $userData ? json_encode($userData) : 'null' ?>;
  </script>

  <!-- React build JS -->
  <script type="module" src="/dist/assets/index.js"></script>
</body>
</html>
