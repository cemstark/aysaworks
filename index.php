<?php
$root = './';
require __DIR__ . '/_inc/site.php';
require __DIR__ . '/_inc/projects.php';

$pageTitle = $site['name'] . ' — ' . $site['tagline'];
$pageDescription = $site['description'];
$pageCanonical = 'index.php';
$pageImage = 'images/home-hero.webp';
$preloadImages = [
    ['src' => 'images/home-hero.webp', 'sizes' => '100vw'],
];
$featured = array_slice($projects, 0, 4, true);

require __DIR__ . '/_inc/header.php';
?>

<section class="hero">
  <div class="hero__media">
    <?= responsive_img('images/home-hero.webp', 'Aysa Works giriş görseli', '100vw', ['fetchpriority' => 'high']) ?>
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
          <?= responsive_img($p['cover'], $p['title'], '(max-width: 900px) 50vw, 33vw', ['loading' => 'lazy']) ?>
        </div>
        <h3 class="project-card__title"><?= e($p['title']) ?></h3>
        <p class="project-card__meta"><?= e($p['sub']) ?> · <?= e($p['location']) ?> · <?= e((string)$p['year']) ?></p>
      </a>
    <?php endforeach; ?>
  </div>
</section>

<?php require __DIR__ . '/_inc/footer.php'; ?>
