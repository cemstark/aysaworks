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
  </div>
</section>

<section class="intro">
  <div class="intro__inner">
    <p>AYSAWORKS, iç mimekan tasarımı ve görselleştirme alanında estetik, işlevsellik ve güçlü mekân algısını bir araya getirerek konut ve ticari projeler için profesyonel tasarım çözümleri sunar. Zamansız çizgi, sade anlatım ve detay odaklı yaklaşımıyla her projeye özgün ve kalıcı bir değer kazandırır.</p>
  </div>
</section>

<section class="projects">
  <h2 class="section-title">Son işler</h2>

  <div class="project-grid">
    <?php foreach ($featured as $slug => $p): ?>
      <a class="project-card" href="<?= e(project_url($slug)) ?>">
        <div class="project-card__img">
          <img src="<?= e(url($p['cover'])) ?>" alt="<?= e($p['title']) ?>" loading="lazy" decoding="async" />
        </div>
        <h3 class="project-card__title"><?= e($p['title']) ?></h3>
        <p class="project-card__meta"><?= e($p['sub']) ?> · <?= e($p['location']) ?> · <?= e((string)$p['year']) ?></p>
      </a>
    <?php endforeach; ?>
  </div>
</section>

<?php require __DIR__ . '/_inc/footer.php'; ?>
