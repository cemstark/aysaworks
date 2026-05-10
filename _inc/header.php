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
$mainCssUrl = asset_url('assets/css/main.css');

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
  <style>
    :root{--bg:#f5f1e5;--header-bg:#fbfaf5;--ink:#383839;--line:#d8d2c2;--sans:'Source Sans 3',system-ui,-apple-system,BlinkMacSystemFont,sans-serif;--gutter:clamp(20px,4vw,64px);--header-h:84px}
    *{box-sizing:border-box;margin:0;padding:0}body{background:var(--bg);color:var(--ink);font-family:var(--sans);font-size:11px;font-weight:500;line-height:1.7;letter-spacing:.5px;overflow-x:hidden}a{color:inherit;text-decoration:none}img{display:block;max-width:100%;height:auto}.site-header{position:fixed;top:0;left:0;right:0;height:var(--header-h);background:var(--header-bg);z-index:100;display:flex;align-items:center;padding:0 var(--gutter);border-bottom:1px solid transparent}.site-header__inner{display:grid;grid-template-columns:1fr auto 1fr;align-items:center;width:100%;max-width:1440px;margin:0 auto;gap:32px}.brand{display:flex;align-items:center;gap:14px;min-height:48px;font-size:13px;font-weight:600;letter-spacing:3px;text-transform:uppercase}.brand-logo-wrap{display:inline-flex;align-items:center;justify-content:center;width:clamp(36px,3.2vw,44px);height:clamp(34px,3vw,42px);padding:4px}.brand-logo{width:100%;height:100%;object-fit:contain}.brand__name{white-space:nowrap}.nav{display:flex;justify-content:center;gap:32px;list-style:none;font-size:11px;font-weight:400;letter-spacing:2px;text-transform:uppercase;line-height:1}.nav>li{position:relative;padding:32px 0}.header-right{justify-self:end;font-size:11px;letter-spacing:2px;text-transform:uppercase}.menu-toggle{display:none}main{padding-top:var(--header-h)}.hero__media{width:100%;aspect-ratio:2560/1212;overflow:hidden;background:#e1dbd0}.hero__media img{width:100%;height:100%;object-fit:contain;object-position:center}@media(max-width:1180px){:root{--header-h:58px;--gutter:clamp(10px,3vw,14px)}.site-header__inner{grid-template-columns:auto minmax(0,1fr) auto;gap:12px}.brand-logo-wrap{width:34px;height:32px;padding:2px}.brand__name,.header-right{display:none}.menu-toggle{display:block;justify-self:end;background:none;border:0;width:44px;height:44px;color:var(--ink)}.menu-toggle span{display:block;width:22px;height:1px;background:currentColor;margin:5px auto}.nav{position:fixed;top:var(--header-h);left:0;right:0;display:flex;flex-direction:column;align-items:stretch;gap:0;margin:0;padding:18px var(--gutter) 28px;background:rgba(251,250,245,.96);border-top:1px solid var(--line);opacity:0;visibility:hidden;pointer-events:none}.nav.is-open{opacity:1;visibility:visible;pointer-events:auto}.nav>li{padding:0;border-bottom:1px solid var(--line)}.nav>li>a{display:flex;justify-content:space-between;min-height:46px;padding:14px 0;white-space:normal;line-height:1.25}.hero__media{aspect-ratio:4/3;max-height:70vh}.hero__media img{object-fit:cover}}
  </style>
  <?php foreach ($preloadImages as $preloadImage): ?>
    <?= preload_image_link((string)$preloadImage['src'], (string)$preloadImage['sizes']) . "\n" ?>
  <?php endforeach; ?>
  <link rel="preload" href="<?= e(url('assets/fonts/SourceSans3-Regular.otf.woff2')) ?>" as="font" type="font/woff2" crossorigin />
  <link rel="preload" href="<?= e(url('assets/fonts/SourceSans3-Medium.otf.woff2')) ?>" as="font" type="font/woff2" crossorigin />
  <link rel="preload" href="<?= e($mainCssUrl) ?>" as="style" />
  <link rel="stylesheet" href="<?= e($mainCssUrl) ?>" media="print" onload="this.media='all'" />
  <noscript><link rel="stylesheet" href="<?= e($mainCssUrl) ?>" /></noscript>
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
