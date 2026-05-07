<?php
declare(strict_types=1);

$designs = [
    'sahil-karyolasi' => [
        'title'    => 'Sahil Karyolası',
        'category' => 'mobilya',
        'sub'      => 'Ahşap',
        'year'     => 2026,
        'cover'    => 'images/yatakodasi3.jpeg',
    ],
    'divan-koltuk' => [
        'title'    => 'Diván Koltuk',
        'category' => 'mobilya',
        'sub'      => 'Tekstil',
        'year'     => 2025,
        'cover'    => 'images/oda.jpeg',
    ],
    'tas-sehpa' => [
        'title'    => 'Taş Sehpa',
        'category' => 'mobilya',
        'sub'      => 'Doğal taş',
        'year'     => 2025,
        'cover'    => 'images/yatakodasi1.jpeg',
    ],
    'konsol-modulu' => [
        'title'    => 'Konsol Modülü',
        'category' => 'mobilya',
        'sub'      => 'Meşe',
        'year'     => 2024,
        'cover'    => 'images/yatakodasi.jpeg',
    ],
    'iskemle-01' => [
        'title'    => 'İskemle 01',
        'category' => 'mobilya',
        'sub'      => 'Ahşap',
        'year'     => 2024,
        'cover'    => 'images/yatakodasi2.png',
    ],
    'mutfak-adasi' => [
        'title'    => 'Mutfak Adası',
        'category' => 'mobilya',
        'sub'      => 'Özel üretim',
        'year'     => 2023,
        'cover'    => 'images/mutfak2.jpeg',
    ],

    'toprak-vazo' => [
        'title'    => 'Toprak Vazo',
        'category' => 'obje',
        'sub'      => 'Seramik',
        'year'     => 2026,
        'cover'    => 'images/image00009.jpeg',
    ],
    'halka-sarkit' => [
        'title'    => 'Halka Sarkıt',
        'category' => 'obje',
        'sub'      => 'Pirinç + Cam',
        'year'     => 2025,
        'cover'    => 'images/oda.jpeg',
    ],
    'mermer-tepsi' => [
        'title'    => 'Mermer Tepsi',
        'category' => 'obje',
        'sub'      => 'Doğal taş',
        'year'     => 2025,
        'cover'    => 'images/banyo1.jpeg',
    ],
    'keten-yastik' => [
        'title'    => 'Keten Yastık',
        'category' => 'obje',
        'sub'      => 'Tekstil',
        'year'     => 2024,
        'cover'    => 'images/yatakodasi3.jpeg',
    ],
];

function designs_by_category(array $designs, string $category): array
{
    return array_filter($designs, static fn($d) => $d['category'] === $category);
}
