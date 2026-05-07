<?php
/**
 * Sayfa header'ı.
 * Beklenen değişkenler:
 *   $root       — köke giden relatif yol ('./' veya '../')
 *   $pageTitle  — <title> içeriği
 *   $site, $nav — _inc/site.php'den gelir
 */
$root = $root ?? './';
$pageTitle = $pageTitle ?? ($site['name'] . ' — ' . $site['tagline']);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= e($pageTitle) ?></title>
  <link rel="icon" type="image/webp" href="<?= e(url('images/logo.webp')) ?>" />
  <link rel="stylesheet" href="<?= e(url('assets/css/main.css')) ?>" />
</head>
<body>

<header class="site-header">
  <div class="site-header__inner">
    <a href="<?= e(url('index.php')) ?>" class="brand">
      <img src="<?= e(url('images/logo.webp')) ?>" alt="<?= e($site['name']) ?>" />
      <span class="brand__name"><?= e($site['name']) ?></span>
    </a>
    <nav>
      <ul class="nav">
        <?php foreach ($nav as $item): ?>
          <?php if (!empty($item['children'])): ?>
            <li class="has-sub">
              <a href="#" aria-haspopup="true"><?= e($item['label']) ?></a>
              <ul class="submenu" role="menu">
                <?php foreach ($item['children'] as $child): ?>
                  <li><a href="<?= e(url($child['href'])) ?>"><?= e($child['label']) ?></a></li>
                <?php endforeach; ?>
              </ul>
            </li>
          <?php else: ?>
            <li><a href="<?= e(url($item['href'])) ?>"><?= e($item['label']) ?></a></li>
          <?php endif; ?>
        <?php endforeach; ?>
      </ul>
    </nav>
    <div class="header-right"><span><?= e($site['city']) ?></span></div>
    <button class="menu-toggle" aria-label="Menü">
      <span></span><span></span><span></span>
    </button>
  </div>
</header>

<main>
