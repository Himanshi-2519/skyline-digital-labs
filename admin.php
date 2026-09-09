<?php

// password 
$adminPassword = "Skyline@Admin123"; 
$loggedIn = false;

if (isset($_POST["password"]) && $_POST["password"] === $adminPassword) {
    $loggedIn = true;
} elseif (isset($_GET["password"]) && $_GET["password"] === $adminPassword) {
    $loggedIn = true;
}

function loadJsonFile($path) {
    if (!file_exists($path)) {
        return [];
    }
    $raw = file_get_contents($path);
    $decoded = json_decode($raw, true);
    return is_array($decoded) ? array_reverse($decoded) : [];
}

$clientEnquiries = [];
$studentApplications = [];
$newsletterSignups = [];

if ($loggedIn) {
    $clientEnquiries = loadJsonFile(__DIR__ . "/data/client-enquiries.json");
    $studentApplications = loadJsonFile(__DIR__ . "/data/student-applications.json");
    $newsletterSignups = loadJsonFile(__DIR__ . "/data/newsletter.json");
}

$activeTab = $_GET["tab"] ?? "client";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin | Skyline Digital Labs</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css">
<link rel="stylesheet" href="css/style.css">
<style>
  .admin-wrap{background:var(--navy-900);color:var(--ink);min-height:100vh;padding:40px 0;}
  .admin-tabs{display:flex;gap:10px;margin-bottom:24px;}
  .admin-tab{padding:10px 20px;border-radius:999px;border:1px solid var(--navy-600);color:var(--ink-muted);text-decoration:none;font-size:14px;}
  .admin-tab.is-active{background:var(--gold);color:var(--navy-900);border-color:var(--gold);}
  .admin-card{background:var(--navy-800);border:1px solid var(--navy-700);border-radius:12px;padding:20px;margin-bottom:16px;}
  .admin-card-top{display:flex;justify-content:space-between;flex-wrap:wrap;gap:8px;}
  .admin-meta{color:var(--ink-muted);font-size:13px;}
</style>
</head>
<body class="admin-wrap">
<div class="container">

  <h1 style="font-family:var(--serif);margin-bottom:24px;">Skyline Digital Labs &mdash; Admin</h1>

  <?php if (!$loggedIn): ?>
    <form method="post" style="max-width:320px;">
      <div class="sky-form-group">
        <label for="password">Admin password</label>
        <input type="password" id="password" name="password" required>
      </div>
      <button type="submit" class="sky-btn sky-btn-primary">Log in</button>
    </form>

  <?php else: ?>

    <div class="admin-tabs">
      <a href="?password=<?php echo urlencode($adminPassword); ?>&tab=client" class="admin-tab <?php echo $activeTab === "client" ? "is-active" : ""; ?>">
        Client enquiries (<?php echo count($clientEnquiries); ?>)
      </a>
      <a href="?password=<?php echo urlencode($adminPassword); ?>&tab=student" class="admin-tab <?php echo $activeTab === "student" ? "is-active" : ""; ?>">
        Career applications (<?php echo count($studentApplications); ?>)
      </a>
      <a href="?password=<?php echo urlencode($adminPassword); ?>&tab=newsletter" class="admin-tab <?php echo $activeTab === "newsletter" ? "is-active" : ""; ?>">
        Newsletter (<?php echo count($newsletterSignups); ?>)
      </a>
    </div>

    <?php if ($activeTab === "client"): ?>
      <?php if (empty($clientEnquiries)): ?>
        <p class="admin-meta">No client enquiries yet.</p>
      <?php else: foreach ($clientEnquiries as $e): ?>
        <div class="admin-card">
          <div class="admin-card-top">
            <strong><?php echo htmlspecialchars($e["name"]); ?></strong>
            <span class="admin-meta"><?php echo htmlspecialchars($e["submitted"]); ?></span>
          </div>
          <p class="admin-meta" style="margin:8px 0;">
            <?php echo htmlspecialchars($e["email"]); ?>
            <?php if (!empty($e["phone"])): ?> &middot; <?php echo htmlspecialchars($e["phone"]); ?><?php endif; ?>
            <?php if (!empty($e["budget"])): ?> &middot; Budget: <?php echo htmlspecialchars($e["budget"]); ?><?php endif; ?>
          </p>
          <p style="margin:0;"><?php echo nl2br(htmlspecialchars($e["message"])); ?></p>
        </div>
      <?php endforeach; endif; ?>

    <?php elseif ($activeTab === "student"): ?>
      <?php if (empty($studentApplications)): ?>
        <p class="admin-meta">No career applications yet.</p>
      <?php else: foreach ($studentApplications as $a): ?>
        <div class="admin-card">
          <div class="admin-card-top">
            <strong><?php echo htmlspecialchars($a["name"]); ?></strong>
            <span class="admin-meta"><?php echo htmlspecialchars($a["submitted"]); ?></span>
          </div>
          <p class="admin-meta" style="margin:8px 0;">
            <?php echo htmlspecialchars($a["email"]); ?>
            <?php if (!empty($a["phone"])): ?> &middot; <?php echo htmlspecialchars($a["phone"]); ?><?php endif; ?>
            <?php if (!empty($a["role"])): ?> &middot; Applying for: <?php echo htmlspecialchars($a["role"]); ?><?php endif; ?>
          </p>
          <p style="margin:0;"><?php echo nl2br(htmlspecialchars($a["message"])); ?></p>
        </div>
      <?php endforeach; endif; ?>

    <?php elseif ($activeTab === "newsletter"): ?>
      <?php if (empty($newsletterSignups)): ?>
        <p class="admin-meta">No newsletter signups yet.</p>
      <?php else: foreach ($newsletterSignups as $n): ?>
        <div class="admin-card">
          <div class="admin-card-top">
            <strong><?php echo htmlspecialchars($n["email"]); ?></strong>
            <span class="admin-meta"><?php echo htmlspecialchars($n["subscribed"]); ?></span>
          </div>
        </div>
      <?php endforeach; endif; ?>
    <?php endif; ?>

  <?php endif; ?>

</div>
</body>
</html>
