<?php
declare(strict_types=1);

$projects = [
    'mutfak' => [
        'title'    => 'Mutfak',
        'category' => 'konut',
        'sub'      => 'Mutfak',
        'location' => 'İstanbul',
        'year'     => 2026,
        'cover'    => 'images/mutfak.webp',
        'intro'    => 'Mutfak projesi; sade yüzeyler, doğal doku ve işlevsel depolama çözümleriyle günlük kullanımı güçlü bir estetikle birleştiren iç mekân tasarımıdır.',
        'gallery'  => [
            ['kind' => 'full', 'src' => 'images/mutfak.webp', 'alt' => 'Mutfak ana görseli'],
            ['kind' => 'pair', 'images' => [
                ['src' => 'images/mutfak1.webp', 'alt' => 'Mutfak ada detayı'],
                ['src' => 'images/mutfak2.webp', 'alt' => 'Mutfak dolap detayı'],
            ]],
        ],
    ],

    'banyo' => [
        'title'    => 'Banyo',
        'category' => 'konut',
        'sub'      => 'Banyo',
        'location' => 'İstanbul',
        'year'     => 2026,
        'cover'    => 'images/banyo.webp',
        'intro'    => 'Banyo projesi; yalın malzeme dili, dengeli ışık kullanımı ve detay odaklı yüzey çözümleriyle sakin ve zamansız bir mekân algısı kurar.',
        'gallery'  => [
            ['kind' => 'pair', 'images' => [
                ['src' => 'images/banyo.webp', 'alt' => 'Banyo ana görseli'],
                ['src' => 'images/banyo1.webp', 'alt' => 'Banyo detay görseli'],
            ]],
        ],
    ],

    'yatak-odasi' => [
        'title'    => 'Yatak Odası',
        'category' => 'konut',
        'sub'      => 'Yatak Odası',
        'location' => 'İstanbul',
        'year'     => 2025,
        'cover'    => 'images/yatakodasi.webp',
        'intro'    => 'Yatak odası projesi; tekstil, ışık ve mobilya oranlarını dengeli bir kompozisyonda buluşturarak dinlenme alanına dingin ve kişisel bir karakter kazandırır.',
        'gallery'  => [
            ['kind' => 'full', 'src' => 'images/yatakodasi.webp', 'alt' => 'Yatak odası ana görseli'],
            ['kind' => 'pair', 'images' => [
                ['src' => 'images/yatakodasi1.webp', 'alt' => 'Yatak odası görünümü'],
                ['src' => 'images/yatakodasi-clean.webp', 'alt' => 'Yatak odası ikinci görünüm'],
            ]],
            ['kind' => 'full', 'src' => 'images/yatakodasi3.webp', 'alt' => 'Yatak odası detay görseli'],
        ],
    ],

    'oda' => [
        'title'    => 'Yaşam Alanı',
        'category' => 'konut',
        'sub'      => 'Yaşam Alanı',
        'location' => 'İstanbul',
        'year'     => 2025,
        'cover'    => 'images/oda.webp',
        'intro'    => 'Yaşam alanı projesi; açık hacim, sade mobilya dili ve güçlü mekân algısını bir araya getirerek kullanıcının ritmine uyum sağlayan bir iç mekân kurgusu sunar.',
        'gallery'  => [
            ['kind' => 'pair', 'images' => [
                ['src' => 'images/oda.webp', 'alt' => 'Yaşam alanı ana görseli'],
                ['src' => 'images/oda-detail.webp', 'alt' => 'Yaşam alanı ikinci görseli'],
            ]],
        ],
    ],

    'merdiven' => [
        'title'    => 'Merdiven',
        'category' => 'konut',
        'sub'      => 'Geçiş Alanı',
        'location' => 'İstanbul',
        'year'     => 2024,
        'cover'    => 'images/merdiven.webp',
        'intro'    => 'Merdiven projesi; geçiş alanını yalnızca dolaşım elemanı olarak değil, ışık, oran ve malzeme ilişkisiyle mekânın güçlü bir parçası olarak ele alır.',
        'gallery'  => [
            ['kind' => 'full', 'src' => 'images/merdiven.webp', 'alt' => 'Merdiven görseli'],
        ],
    ],

    'otel' => [
        'title'    => 'Otel',
        'category' => 'ticari',
        'sub'      => 'Otel',
        'location' => 'İzmir',
        'year'     => 2024,
        'cover'    => 'images/otel.webp',
        'intro'    => 'Otel projesi; konaklama deneyimini sıcak, sade ve akılda kalıcı bir mekân diliyle destekleyen ticari iç mimari ve görselleştirme çalışmasıdır.',
        'gallery'  => [
            ['kind' => 'full', 'src' => 'images/otel.webp', 'alt' => 'Otel iç mekân görseli'],
        ],
    ],

    'cafe' => [
        'title'    => 'Cafe',
        'category' => 'ticari',
        'sub'      => 'Cafe',
        'nav_group' => 'cafe-restoran',
        'location' => 'İstanbul',
        'year'     => 2025,
        'cover'    => 'images/image00009.webp',
        'intro'    => 'Cafe projesi; misafir akışını, oturma düzenini ve atmosfer etkisini birlikte değerlendirerek davetkâr ve işlevsel bir ticari mekân kurgusu oluşturur.',
        'gallery'  => [
            ['kind' => 'full', 'src' => 'images/image00009.webp', 'alt' => 'Cafe iç mekân görseli'],
        ],
    ],
];

function projects_by_category(array $projects, string $category): array
{
    return array_filter($projects, static fn($p) => $p['category'] === $category);
}

function projects_by_nav_group(array $projects, string $category, string $navGroup): array
{
    return array_filter(
        $projects,
        static fn($p) => $p['category'] === $category && ($p['nav_group'] ?? '') === $navGroup
    );
}

function find_project(array $projects, string $slug): ?array
{
    return $projects[$slug] ?? null;
}

function project_url(string $slug, string $root = ''): string
{
    return url('projeler/proje.php?slug=' . urlencode($slug), $root);
}
