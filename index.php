<?php
$root = './';
require __DIR__ . '/_inc/site.php';
require __DIR__ . '/_inc/projects.php';

$pageTitle = $site['name'] . ' — ' . $site['tagline'];
$featured = array_slice($projects, 0, 4, true);

require __DIR__ . '/_inc/header.php';
?>

<section class="hero">
  <div class="hero__media">
    <img src="<?= e(url('images/oda.webp')) ?>" alt="Aysa Works iç mekân — sade yaşam alanı" width="2560" height="1212" fetchpriority="high" decoding="async" />
    <p class="hero__caption">Mekân ve malzemeyle<br/>sessiz bir diyalog.</p>
  </div>
</section>

<section class="intro">
  <div class="intro__inner">
    <p class="eyebrow">Stüdyo</p>
    <h2><?= e($site['name']) ?>, sade ve dürüst bir mimari dil arar.</h2>
    <p>Konut ve ticari iç mekânlarda; ışığın, dokunun ve oranın temel rol oynadığı, zamanla olgunlaşan tasarımlar üretiriz. Her proje, kullanıcısıyla birlikte yaşayacak bir karaktere sahiptir — özenli detay, doğal malzeme ve ölçülü hareket bizim için pusuladır.</p>
  </div>
</section>

<section class="projects">
  <p class="section-eyebrow">Seçili Projeler</p>
  <h2 class="section-title">Son işler</h2>

  <div class="project-grid">
    <?php foreach ($featured as $slug => $p): ?>
      <a class="project-card" href="<?= e(project_url($slug)) ?>">
        <div class="project-card__img">
          <img src="<?= e(url($p['cover'])) ?>" alt="<?= e($p['title']) ?>" />
        </div>
        <h3 class="project-card__title"><?= e($p['title']) ?></h3>
        <p class="project-card__meta"><?= e($p['sub']) ?> · <?= e($p['location']) ?> · <?= e((string)$p['year']) ?></p>
      </a>
    <?php endforeach; ?>
  </div>
</section>

<?php require __DIR__ . '/_inc/footer.php'; ?>
