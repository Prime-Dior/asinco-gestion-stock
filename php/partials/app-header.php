<?php
/** Layout app shell (topbar + sidebar) — utilisé par toutes les pages app */
include __DIR__ . '/head.php';
include __DIR__ . '/topbar.php';
?>
<div class="app-shell">
  <?php include __DIR__ . '/sidebar.php'; ?>
  <main class="app-main">
