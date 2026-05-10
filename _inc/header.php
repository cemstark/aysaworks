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
$pageDescription = $pageDescription ?? $site['description'];
$pageImage = $pageImage ?? 'images/oda.webp';
$pageCanonical = $pageCanonical ?? ltrim(parse_url($_SERVER['REQUEST_URI'] ?? 'index.php', PHP_URL_PATH) ?: 'index.php', '/');
$pageType = $pageType ?? 'website';
$robotsContent = $robotsContent ?? 'index, follow';
$structuredData = $structuredData ?? [];
$preloadImages = $preloadImages ?? [];

$organizationSchema = [
    '@context' => 'https://schema.org',
    '@type' => 'ProfessionalService',
    '@id' => absolute_url('#organization'),
    'name' => $site['name'],
    'url' => absolute_url(),
    'description' => $site['description'],
    'image' => absolute_url($pageImage),
    'email' => $site['email'],
    'areaServed' => [
        '@type' => 'City',
        'name' => $site['city'],
    ],
    'address' => [
        '@type' => 'PostalAddress',
        'addressLocality' => $site['city'],
        'addressCountry' => 'TR',
    ],
    'sameAs' => [
        $site['instagram'],
    ],
];

$webPageSchema = [
    '@context' => 'https://schema.org',
    '@type' => 'WebPage',
    '@id' => absolute_url($pageCanonical) . '#webpage',
    'url' => absolute_url($pageCanonical),
    'name' => $pageTitle,
    'description' => $pageDescription,
    'isPartOf' => [
        '@type' => 'WebSite',
        '@id' => absolute_url('#website'),
        'name' => $site['name'],
        'url' => absolute_url(),
    ],
    'publisher' => [
        '@id' => absolute_url('#organization'),
    ],
];

$schemaGraph = array_merge([$organizationSchema, $webPageSchema], $structuredData);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
  <meta name="theme-color" content="#f5f1e5" />
  <meta name="format-detection" content="telephone=no" />
  <meta name="description" content="<?= e($pageDescription) ?>" />
  <meta name="robots" content="<?= e($robotsContent) ?>" />
  <link rel="canonical" href="<?= e(absolute_url($pageCanonical)) ?>" />
  <meta property="og:title" content="<?= e($pageTitle) ?>" />
  <meta property="og:description" content="<?= e($pageDescription) ?>" />
  <meta property="og:image" content="<?= e(absolute_url($pageImage)) ?>" />
  <meta property="og:url" content="<?= e(absolute_url($pageCanonical)) ?>" />
  <meta property="og:type" content="<?= e($pageType) ?>" />
  <meta property="og:site_name" content="<?= e($site['name']) ?>" />
  <meta property="og:locale" content="tr_TR" />
  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:title" content="<?= e($pageTitle) ?>" />
  <meta name="twitter:description" content="<?= e($pageDescription) ?>" />
  <meta name="twitter:image" content="<?= e(absolute_url($pageImage)) ?>" />
  <title><?= e($pageTitle) ?></title>
  <link rel="icon" type="image/webp" href="<?= e(url('images/logo.webp')) ?>" />
  <link rel="apple-touch-icon" href="<?= e(url('images/logo.webp')) ?>" />
  <?php foreach ($preloadImages as $preloadImage): ?>
    <?= preload_image_link((string)$preloadImage['src'], (string)$preloadImage['sizes']) . "\n" ?>
  <?php endforeach; ?>
  <link rel="preload" href="<?= e(url('assets/fonts/SourceSans3-Medium.otf.woff2')) ?>" as="font" type="font/woff2" crossorigin />
  <link rel="preload" href="<?= e(url('assets/fonts/SourceSans3-Semibold.otf.woff2')) ?>" as="font" type="font/woff2" crossorigin />
  <link rel="stylesheet" href="<?= e(asset_url('assets/css/main.css')) ?>" />
  <script type="application/ld+json"><?= json_encode(['@context' => 'https://schema.org', '@graph' => $schemaGraph], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>
</head>
<body>

<header class="site-header">
  <div class="site-header__inner">
    <a href="<?= e(url('index.php')) ?>" class="brand">
      <picture class="brand-logo-wrap">
        <source srcset="<?= e(url('assets/logo/aw-logo-header-vector.svg')) ?>" type="image/svg+xml" />
        <img
          src="<?= e(url('assets/logo/aw-logo-header-transparent.png')) ?>"
          srcset="<?= e(url('assets/logo/aw-logo-header-256w.png')) ?> 256w, <?= e(url('assets/logo/aw-logo-header-512w.png')) ?> 512w, <?= e(url('assets/logo/aw-logo-header-1024w.png')) ?> 1024w"
          sizes="(max-width: 480px) 30px, (max-width: 900px) 34px, 44px"
          alt="<?= e($site['name']) ?>"
          class="brand-logo"
          width="1017"
          height="841"
          decoding="async"
        />
      </picture>
      <span class="brand__name"><?= e($site['name']) ?></span>
    </a>
    <nav>
      <ul class="nav">
        <?php foreach ($nav as $item): ?>
          <?php if (!empty($item['children'])): ?>
            <?php
              $itemHref = (string)($item['href'] ?? '#');
              $itemUrl = $itemHref === '#' ? '#' : url($itemHref);
            ?>
            <li class="has-sub">
              <a href="<?= e($itemUrl) ?>" aria-haspopup="true"><?= e($item['label']) ?></a>
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
