<?php
declare(strict_types=1);

$designs = [
    'sahil-karyolasi' => [
        'title'    => 'Sahil Karyolası',
        'category' => 'mobilya',
        'sub'      => 'Ahşap',
        'year'     => 2026,
        'cover'    => 'images/yatakodasi3.webp',
    ],
    'divan-koltuk' => [
        'title'    => 'Diván Koltuk',
        'category' => 'mobilya',
        'sub'      => 'Tekstil',
        'year'     => 2025,
        'cover'    => 'images/oda.webp',
    ],
    'tas-sehpa' => [
        'title'    => 'Taş Sehpa',
        'category' => 'mobilya',
        'sub'      => 'Doğal taş',
        'year'     => 2025,
        'cover'    => 'images/yatakodasi1.webp',
    ],
    'konsol-modulu' => [
        'title'    => 'Konsol Modülü',
        'category' => 'mobilya',
        'sub'      => 'Meşe',
        'year'     => 2024,
        'cover'    => 'images/yatakodasi.webp',
    ],
    'iskemle-01' => [
        'title'    => 'İskemle 01',
        'category' => 'mobilya',
        'sub'      => 'Ahşap',
        'year'     => 2024,
        'cover'    => 'images/yatakodasi-clean.webp',
    ],
    'mutfak-adasi' => [
        'title'    => 'Mutfak Adası',
        'category' => 'mobilya',
        'sub'      => 'Özel üretim',
        'year'     => 2023,
        'cover'    => 'images/mutfak2.webp',
    ],

    'toprak-vazo' => [
        'title'    => 'Toprak Vazo',
        'category' => 'obje',
        'sub'      => 'Seramik',
        'year'     => 2026,
        'cover'    => 'images/image00009.webp',
    ],
    'halka-sarkit' => [
        'title'    => 'Halka Sarkıt',
        'category' => 'obje',
        'sub'      => 'Pirinç + Cam',
        'year'     => 2025,
        'cover'    => 'images/oda.webp',
    ],
    'mermer-tepsi' => [
        'title'    => 'Mermer Tepsi',
        'category' => 'obje',
        'sub'      => 'Doğal taş',
        'year'     => 2025,
        'cover'    => 'images/banyo1.webp',
    ],
    'keten-yastik' => [
        'title'    => 'Keten Yastık',
        'category' => 'obje',
        'sub'      => 'Tekstil',
        'year'     => 2024,
        'cover'    => 'images/yatakodasi3.webp',
    ],
];

function designs_by_category(array $designs, string $category): array
{
    return array_filter($designs, static fn($d) => $d['category'] === $category);
}
