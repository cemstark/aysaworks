<?php
declare(strict_types=1);

$projects = [
    'karakoy-rezidansi' => [
        'title'    => 'Karaköy Rezidansı',
        'category' => 'konut',
        'sub'      => 'Apartman',
        'location' => 'İstanbul',
        'year'     => 2026,
        'cover'    => 'images/mutfak.jpeg',
        'intro'    => 'Boğaz manzaralı tarihi bir yapının yenilenmesinde, dokunun ve ışığın başrol oynadığı bir konut iç mimarisi. Tavanın doğal yüksekliğine duyulan saygıyla, malzeme paleti sade tutuldu: tonlu sıva, doğal taş ve özenle seçilmiş ahşap birlikte sessiz bir bütün oluşturuyor.',
        'gallery'  => [
            ['kind' => 'full', 'src' => 'images/mutfak.jpeg',     'alt' => 'Mutfak ana görseli'],
            ['kind' => 'pair', 'images' => [
                ['src' => 'images/mutfak1.jpeg', 'alt' => 'Mutfak ada detayı'],
                ['src' => 'images/mutfak2.jpeg', 'alt' => 'Mutfak ahşap dolap detayı'],
            ]],
            ['kind' => 'full', 'src' => 'images/yatakodasi.jpeg', 'alt' => 'Yatak odası'],
            ['kind' => 'pair', 'images' => [
                ['src' => 'images/banyo.jpeg',  'alt' => 'Banyo'],
                ['src' => 'images/banyo1.jpeg', 'alt' => 'Banyo seramik detay'],
            ]],
            ['kind' => 'full', 'src' => 'images/merdiven.png',    'alt' => 'Merdiven boşluğu'],
            ['kind' => 'pair', 'images' => [
                ['src' => 'images/yatakodasi.jpeg',  'alt' => 'Ana yatak odası'],
                ['src' => 'images/yatakodasi3.jpeg', 'alt' => 'Yatak odası tekstil detayı'],
            ]],
        ],
    ],

    'yildiz-park-apartmani' => [
        'title'    => 'Yıldız Park Apartmanı',
        'category' => 'konut',
        'sub'      => 'Apartman',
        'location' => 'İstanbul',
        'year'     => 2025,
        'cover'    => 'images/banyo.jpeg',
        'intro'    => 'Park manzarasına bakan bir apartman dairesinde; günışığını, doğal taşı ve özel üretim mobilyaları sade bir paletle bir araya getiren konut iç mimarisi.',
        'gallery'  => [
            ['kind' => 'full', 'src' => 'images/banyo.jpeg',  'alt' => 'Ana banyo'],
            ['kind' => 'pair', 'images' => [
                ['src' => 'images/banyo1.jpeg',  'alt' => 'Banyo detay'],
                ['src' => 'images/yatakodasi1.jpeg', 'alt' => 'Yatak odası'],
            ]],
            ['kind' => 'full', 'src' => 'images/oda.jpeg',    'alt' => 'Yaşama alanı'],
        ],
    ],

    'bebek-sahil-evi' => [
        'title'    => 'Bebek Sahil Evi',
        'category' => 'konut',
        'sub'      => 'Müstakil',
        'location' => 'İstanbul',
        'year'     => 2025,
        'cover'    => 'images/yatakodasi2.png',
        'intro'    => 'Boğaz kıyısında bir aile evinde, deniz ışığını içeri taşıyan, açık plan ile mahremiyeti dengeleyen sıcak bir iç mimari yaklaşımı.',
        'gallery'  => [
            ['kind' => 'full', 'src' => 'images/yatakodasi2.png', 'alt' => 'Ana yatak odası'],
            ['kind' => 'pair', 'images' => [
                ['src' => 'images/yatakodasi.jpeg',  'alt' => 'Yatak odası detayı'],
                ['src' => 'images/yatakodasi3.jpeg', 'alt' => 'Yastık ve tekstil'],
            ]],
        ],
    ],

    'tarabya-konagi' => [
        'title'    => 'Tarabya Konağı',
        'category' => 'konut',
        'sub'      => 'Müstakil',
        'location' => 'İstanbul',
        'year'     => 2024,
        'cover'    => 'images/yatakodasi.jpeg',
        'intro'    => 'Yüzyıllık bir konağın iç mekânının; orijinal mimari izlere saygılı, çağdaş bir konfor ile yorumlandığı kapsamlı bir restorasyon-tasarım projesi.',
        'gallery'  => [
            ['kind' => 'full', 'src' => 'images/yatakodasi.jpeg', 'alt' => 'Yatak odası'],
            ['kind' => 'full', 'src' => 'images/merdiven.png',    'alt' => 'Tarihi merdiven'],
        ],
    ],

    'cihangir-studyo' => [
        'title'    => 'Cihangir Stüdyo',
        'category' => 'konut',
        'sub'      => 'Stüdyo',
        'location' => 'İstanbul',
        'year'     => 2024,
        'cover'    => 'images/yatakodasi1.jpeg',
        'intro'    => 'Küçük bir stüdyo dairede; çoklu işlevi tek bir hacme yedirilmiş, ahşap özel üretimle kurulmuş minimal bir yaşam çözümü.',
        'gallery'  => [
            ['kind' => 'full', 'src' => 'images/yatakodasi1.jpeg', 'alt' => 'Stüdyo daire'],
        ],
    ],

    'etiler-tripleks' => [
        'title'    => 'Etiler Tripleks',
        'category' => 'konut',
        'sub'      => 'Müstakil',
        'location' => 'İstanbul',
        'year'     => 2023,
        'cover'    => 'images/merdiven.png',
        'intro'    => 'Üç katlı bir aile evinde; merkez merdiven boşluğu üzerinden örgütlenen, doğal ışığı tüm katlara taşıyan modern bir konut yorumu.',
        'gallery'  => [
            ['kind' => 'full', 'src' => 'images/merdiven.png', 'alt' => 'Merdiven boşluğu'],
            ['kind' => 'full', 'src' => 'images/oda.jpeg',     'alt' => 'Yaşama alanı'],
        ],
    ],

    'cesme-butik-otel' => [
        'title'    => 'Çeşme Butik Otel',
        'category' => 'ticari',
        'sub'      => 'Otel',
        'location' => 'İzmir',
        'year'     => 2024,
        'cover'    => 'images/otel.jpeg',
        'intro'    => 'Ege kıyısında küçük ölçekli bir butik otelde; lobiyi, odaları ve dış mekânı tek bir malzeme dili ile birleştiren bir ticari iç mimari projesi.',
        'gallery'  => [
            ['kind' => 'full', 'src' => 'images/otel.jpeg', 'alt' => 'Otel lobi'],
        ],
    ],

    'galata-konsept-magaza' => [
        'title'    => 'Galata Konsept Mağaza',
        'category' => 'ticari',
        'sub'      => 'Perakende',
        'location' => 'İstanbul',
        'year'     => 2025,
        'cover'    => 'images/oda.jpeg',
        'intro'    => 'Tarihi bir binanın zemin katında; ürünü öne çıkaran, sergileme ile mimarinin iç içe geçtiği bir konsept mağaza tasarımı.',
        'gallery'  => [
            ['kind' => 'full', 'src' => 'images/oda.jpeg', 'alt' => 'Mağaza içi'],
        ],
    ],

    'karakoy-cafe' => [
        'title'    => 'Karaköy Cafe',
        'category' => 'ticari',
        'sub'      => 'Cafe',
        'location' => 'İstanbul',
        'year'     => 2025,
        'cover'    => 'images/image00009.jpeg',
        'intro'    => 'Küçük bir köşe cafe; sıcak doku, doğal ışık ve özel üretim mobilyalarla; günün her saatinde misafiri ağırlayan davetkar bir atmosfer.',
        'gallery'  => [
            ['kind' => 'full', 'src' => 'images/image00009.jpeg', 'alt' => 'Cafe iç mekân'],
        ],
    ],
];

function projects_by_category(array $projects, string $category): array
{
    return array_filter($projects, static fn($p) => $p['category'] === $category);
}

function find_project(array $projects, string $slug): ?array
{
    return $projects[$slug] ?? null;
}

function project_url(string $slug, string $root = ''): string
{
    return url('projeler/proje.php?slug=' . urlencode($slug), $root);
}
