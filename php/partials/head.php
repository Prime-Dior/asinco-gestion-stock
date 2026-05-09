<?php
/**
 * ASINCO — head.php (version Oracle)
 */
$pageTitle = $pageTitle ?? 'ASINCO';
$bodyTheme = $bodyTheme ?? 'dark';

// ── Chargement Oracle  ─────────────────
require_once __DIR__ . '/../data/db.php';
?>
<!doctype html>
<html lang="fr" data-bs-theme="<?= e($bodyTheme) ?>">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($pageTitle) ?> · ASINCO</title>

  <!-- Anti-FOUC : applique le thème stocké AVANT le rendu CSS -->
  <script>
    (function () {
      try {
        var saved = localStorage.getItem('asinco-theme') || 'auto';
        var effective = saved === 'auto'
          ? (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light')
          : saved;
        document.documentElement.setAttribute('data-bs-theme', effective);
        document.documentElement.dataset.themePref = saved;
      } catch (e) {}
    })();
  </script>
  <meta name="description" content="ASINCO — Plateforme de gestion du parc matériel et des maintenances.">

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="<?= e(asinco_url('assets/img/logo.png')) ?>">
  <link rel="apple-touch-icon" href="<?= e(asinco_url('assets/img/logo.png')) ?>">

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Manrope -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;700;800&display=swap" rel="stylesheet">

  <!-- Custom ASINCO -->
  <link href="<?= e(asinco_url('assets/css/custom.css')) ?>" rel="stylesheet">

  <!-- Affichage des messages flash Oracle -->
  <?php if (!empty($_SESSION['flash'])): ?>
  <script>
    window.addEventListener('DOMContentLoaded', function () {
      var flash = <?= json_encode($_SESSION['flash'], JSON_UNESCAPED_UNICODE) ?>;
      if (typeof asincoToast === 'function') {
        asincoToast(flash.type, flash.msg);
      } else {
        var div = document.createElement('div');
        div.className = 'alert alert-' + (flash.type === 'success' ? 'success' : 'danger')
                      + ' alert-dismissible position-fixed top-0 end-0 m-3';
        div.style.zIndex = 9999;
        div.innerHTML = flash.msg
          + '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
        document.body.appendChild(div);
        setTimeout(function(){ div.remove(); }, 5000);
      }
    });
  </script>
  <?php
    unset($_SESSION['flash']);
  endif;
  ?>
</head>
<body>
