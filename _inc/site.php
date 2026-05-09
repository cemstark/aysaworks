<?php
declare(strict_types=1);

$site = [
    'name'      => 'Aysa Works',
    'domain'    => 'aysaworks.com',
    'tagline'   => 'İç Mimarlık & Tasarım Stüdyosu',
    'city'      => 'İstanbul',
    'email'     => 'cemy695@gmail.com',
    'instagram' => 'https://www.instagram.com/aysaworks',
    'year'      => 2026,
];

$nav = [
    ['label' => 'Projeler', 'children' => [
        ['label' => 'Konut',  'href' => 'projeler/konut.php'],
        ['label' => 'Ticari', 'href' => 'projeler/ticari.php'],
    ]],
    ['label' => 'Tasarım', 'children' => [
        ['label' => 'Mobilya', 'href' => 'tasarim/mobilya.php'],
        ['label' => 'Obje',    'href' => 'tasarim/obje.php'],
    ]],
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

function asset_url(string $path, string $root = ''): string
{
    $url = url($path, $root);
    $file = __DIR__ . '/../' . ltrim($path, '/');
    $version = is_file($file) ? (string)filemtime($file) : (string)$GLOBALS['site']['year'];

    return $url . (str_contains($url, '?') ? '&' : '?') . 'v=' . rawurlencode($version);
}
