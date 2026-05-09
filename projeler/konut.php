<?php
$root = '../';
require __DIR__ . '/../_inc/site.php';
require __DIR__ . '/../_inc/projects.php';

$pageTitle = 'Konut Projeleri — ' . $site['name'];
$pageDescription = 'Aysa Works konut iç mimari projeleri: apartman dairesi, ev ve yaşam alanları için sade, zamansız ve malzeme odaklı tasarım çalışmaları.';
$pageCanonical = 'projeler/konut.php';
$pageImage = 'images/mutfak.webp';
$items = projects_by_category($projects, 'konut');

require __DIR__ . '/../_inc/header.php';
?>

<section class="project-hero">
  <h1>Konut</h1>
  <p>Yaşayanların ritmine biçilmiş; sıcak, sessiz ve zamana karşı duran konut iç mimarisi projeleri. Apartman daireleri, müstakil evler ve yazlık konutlar.</p>
</section>

<section class="projects">
  <div class="project-grid">
    <?php foreach ($items as $slug => $p): ?>
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

<?php require __DIR__ . '/../_inc/footer.php'; ?>
