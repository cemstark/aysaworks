<?php
$root = '../';
require __DIR__ . '/../_inc/site.php';
require __DIR__ . '/../_inc/projects.php';

$pageTitle = 'Ticari Projeler — ' . $site['name'];
$items = projects_by_category($projects, 'ticari');

require __DIR__ . '/../_inc/header.php';
?>

<section class="project-hero">
  <h1>Ticari</h1>
  <p>Otel, ofis, mağaza ve restoran iç mekânlarında; markanın sessiz dilini taşıyan, malzeme ve oran üzerinden çalışılan ticari iç mimari projeleri.</p>
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
