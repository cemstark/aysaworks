<?php
declare(strict_types=1);

$site = [
    'name'      => 'Aysa Works',
    'domain'    => 'aysaworks.com',
    'base_url'  => 'https://aysaworks.com',
    'tagline'   => 'İç Mimarlık & Tasarım Stüdyosu',
    'description' => 'İstanbul merkezli iç mimarlık ve tasarım stüdyosu. Konut, ticari mekan, özel mobilya ve obje tasarımı için zamansız, malzeme odaklı çözümler.',
    'city'      => 'İstanbul',
    'email'     => 'cemy695@gmail.com',
    'instagram' => 'https://www.instagram.com/aysaworks',
    'year'      => 2026,
];

$nav = [
    ['label' => 'Konut Projeleri', 'href' => 'projeler/konut.php'],
    ['label' => 'Ticari Projeler', 'href' => 'projeler/ticari.php', 'children' => [
        ['label' => 'Cafe/Restoran', 'href' => 'projeler/ticari.php?alt=cafe-restoran'],
        ['label' => 'Ofis/Dükkan',    'href' => 'projeler/ticari.php?alt=ofis-dukkan'],
    ]],
    ['label' => 'Mobilya/Obje Tasarımları', 'href' => 'tasarim/index.php'],
    ['label' => 'Hakkında', 'href' => 'hakkinda.php'],
    ['label' => 'İletişim', 'href' => 'iletisim.php'],
];

function e(string $s): string
{
    return htmlspecialchars($s, ENT_QUOTES | ENT_HTML5, 'UTF-8');
}

function url(string $path, string $root = ''): string
{
    $root = $root ?: ($GLOBALS['root'] ?? './');
    return $root . ltrim($path, '/');
}

function absolute_url(string $path = ''): string
{
    $base = rtrim((string)$GLOBALS['site']['base_url'], '/');
    $path = ltrim($path, '/');

    return $path === '' ? $base . '/' : $base . '/' . $path;
}

function asset_url(string $path, string $root = ''): string
{
    $url = url($path, $root);
    $file = __DIR__ . '/../' . ltrim($path, '/');
    $version = is_file($file) ? (string)filemtime($file) : (string)$GLOBALS['site']['year'];

    return $url . (str_contains($url, '?') ? '&' : '?') . 'v=' . rawurlencode($version);
}

function image_dimensions(string $path): array
{
    static $cache = [];
    if (isset($cache[$path])) {
        return $cache[$path];
    }

    $file = __DIR__ . '/../' . ltrim($path, '/');
    $info = is_file($file) ? getimagesize($file) : false;
    $cache[$path] = $info ? [(int)$info[0], (int)$info[1]] : [0, 0];

    return $cache[$path];
}

function responsive_image_srcset(string $path): string
{
    [$originalWidth] = image_dimensions($path);
    $info = pathinfo($path);
    $dir = trim((string)($info['dirname'] ?? ''), '.');
    $name = (string)($info['filename'] ?? '');
    $candidates = [480, 768, 1024, 1440, 1920];
    $srcset = [];

    foreach ($candidates as $width) {
        $variant = ltrim($dir . '/responsive/' . $name . '-' . $width . '.webp', '/');
        $file = __DIR__ . '/../' . $variant;
        if (is_file($file)) {
            $srcset[] = url($variant) . ' ' . $width . 'w';
        }
    }

    if ($originalWidth > 0 && strtolower((string)($info['extension'] ?? '')) === 'webp') {
        $srcset[] = url($path) . ' ' . $originalWidth . 'w';
    }

    return implode(', ', array_unique($srcset));
}

function responsive_img(string $path, string $alt, string $sizes, array $attrs = []): string
{
    [$width, $height] = image_dimensions($path);
    $attributes = array_merge([
        'src' => url($path),
        'alt' => $alt,
        'width' => $width > 0 ? (string)$width : null,
        'height' => $height > 0 ? (string)$height : null,
        'decoding' => 'async',
    ], $attrs);

    $srcset = responsive_image_srcset($path);
    if ($srcset !== '') {
        $attributes['srcset'] = $srcset;
        $attributes['sizes'] = $sizes;
    }

    $html = '<img';
    foreach ($attributes as $name => $value) {
        if ($value === null || $value === false) {
            continue;
        }
        if ($value === true) {
            $html .= ' ' . e((string)$name);
            continue;
        }
        $html .= ' ' . e((string)$name) . '="' . e((string)$value) . '"';
    }

    return $html . ' />';
}

function preload_image_link(string $path, string $sizes): string
{
    $srcset = responsive_image_srcset($path);
    $attrs = [
        'rel' => 'preload',
        'as' => 'image',
        'href' => url($path),
    ];

    if ($srcset !== '') {
        $attrs['imagesrcset'] = $srcset;
        $attrs['imagesizes'] = $sizes;
    }

    $html = '<link';
    foreach ($attrs as $name => $value) {
        $html .= ' ' . e($name) . '="' . e($value) . '"';
    }

    return $html . ' />';
}
