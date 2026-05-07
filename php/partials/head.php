<?php
/** Variables attendues : $pageTitle (string), $bodyTheme ('dark'|'light' — défaut 'dark') */
$pageTitle = $pageTitle ?? 'ASINCO';
$bodyTheme = $bodyTheme ?? 'dark';
require_once __DIR__ . '/../data/mock.php';
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

  <!-- Manrope (fallback de Circular) -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;700;800&display=swap" rel="stylesheet">

  <!-- Custom -->
  <link href="<?= e(asinco_url('assets/css/custom.css')) ?>" rel="stylesheet">
</head>
<body>
