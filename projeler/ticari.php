<?php
$root = '../';
require __DIR__ . '/../_inc/site.php';
require __DIR__ . '/../_inc/projects.php';

$pageTitle = 'Ticari Projeler — ' . $site['name'];
$pageDescription = 'Aysa Works ticari iç mimari projeleri: otel, cafe, mağaza ve çalışma alanları için marka diliyle uyumlu mekan tasarımı.';
$pageCanonical = 'projeler/ticari.php';
$pageImage = 'images/otel.webp';
$commercialGroups = [
    'cafe-restoran' => [
        'title' => 'Cafe/Restoran',
        'description' => 'Cafe ve restoran projelerinde; misafir akışını, oturma düzenini, servis kurgusunu ve atmosfer etkisini birlikte ele alan ticari iç mimari çalışmaları.',
    ],
    'ofis-dukkan' => [
        'title' => 'Ofis/Dükkan',
        'description' => 'Ofis, dükkan ve marka deneyimi odaklı ticari mekanlarda; işlev, dolaşım ve malzeme dilini dengeli bir bütünlükte kuran projeler.',
    ],
];
$activeGroup = (string)($_GET['alt'] ?? '');
$group = $commercialGroups[$activeGroup] ?? null;
$items = $group
    ? projects_by_nav_group($projects, 'ticari', $activeGroup)
    : projects_by_category($projects, 'ticari');

if ($group) {
    $pageTitle = $group['title'] . ' — ' . $site['name'];
    $pageDescription = $group['description'];
    $pageCanonical = 'projeler/ticari.php?alt=' . rawurlencode($activeGroup);
}

require __DIR__ . '/../_inc/header.php';
?>

<section class="project-hero">
  <h1><?= e($group['title'] ?? 'Ticari') ?></h1>
  <p><?= e($group['description'] ?? 'Otel, ofis, mağaza ve restoran iç mekânlarında; markanın sessiz dilini taşıyan, malzeme ve oran üzerinden çalışılan ticari iç mimari projeleri.') ?></p>
</section>

<section class="projects">
  <?php if ($items): ?>
    <div class="project-grid">
      <?php foreach ($items as $slug => $p): ?>
        <a class="project-card" href="<?= e(project_url($slug)) ?>">
          <div class="project-card__img">
            <?= responsive_img($p['cover'], $p['title'], '(max-width: 900px) 50vw, 50vw', ['loading' => 'lazy']) ?>
          </div>
          <h3 class="project-card__title"><?= e($p['title']) ?></h3>
          <p class="project-card__meta"><?= e($p['sub']) ?> · <?= e($p['location']) ?> · <?= e((string)$p['year']) ?></p>
        </a>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <p class="empty-state">Bu başlık altındaki projeler yakında eklenecek.</p>
  <?php endif; ?>
</section>

<?php require __DIR__ . '/../_inc/footer.php'; ?>
