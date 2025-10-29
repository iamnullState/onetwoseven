<?php
$app = require __DIR__ . '/../bootstrap/app.php';
$env = $app['env'];

$appName = $env['APP_NAME'] ?? 'OneTwoSeven';
$envName = ucfirst($env['APP_ENV'] ?? 'local');
$debug = $env['APP_DEBUG'] ?? 'false';

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($appName) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-light d-flex flex-column min-vh-100">

  <div class="container text-center my-auto">
    <h1 class="display-4 fw-bold"><?= htmlspecialchars($appName) ?></h1>
    <p class="lead text-secondary">Environment: <strong><?= htmlspecialchars($envName) ?></strong></p>

    

    <p class="mt-3 small text-secondary">
      PHP <?= phpversion() ?> | <?= htmlspecialchars($_SERVER['SERVER_SOFTWARE'] ?? '') ?>
    </p>
  </div>

  <footer class="mt-auto text-center py-3 text-muted small">
    &copy; <?= date('Y') ?> <?= htmlspecialchars($appName) ?> — Built with PHP + Docker
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>