<?php
declare(strict_types=1);

$site = [
    'name'      => 'Aysa Works',
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
