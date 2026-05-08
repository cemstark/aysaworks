<?php
$root = '../';
require __DIR__ . '/../_inc/site.php';
require __DIR__ . '/../_inc/projects.php';

$slug = $_GET['slug'] ?? '';
$project = find_project($projects, (string)$slug);

if (!$project) {
    http_response_code(404);
    $pageTitle = 'Bulunamadı — ' . $site['name'];
    require __DIR__ . '/../_inc/header.php';
    ?>
    <section class="project-hero">
      <h1>Proje bulunamadı</h1>
      <p>Aradığınız proje yayında değil veya kaldırılmış olabilir. <a href="<?= e(url('projeler/konut.php')) ?>">Konut projelerine dön</a>.</p>
    </section>
    <?php
    require __DIR__ . '/../_inc/footer.php';
    return;
}

$pageTitle = $project['title'] . ' — ' . $site['name'];
$category = $project['category'];
$categoryHref = $category === 'ticari' ? 'projeler/ticari.php' : 'projeler/konut.php';
$categoryLabel = $category === 'ticari' ? 'Ticari' : 'Konut';

require __DIR__ . '/../_inc/header.php';
?>

<section class="project-hero">
  <h1><?= e($project['title']) ?></h1>
  <p><?= e($project['intro']) ?></p>
</section>

<section class="project-gallery">
  <?php foreach ($project['gallery'] as $block): ?>
    <?php if ($block['kind'] === 'full'): ?>
      <img src="<?= e(url($block['src'])) ?>" alt="<?= e($block['alt']) ?>" loading="lazy" decoding="async" />
    <?php elseif ($block['kind'] === 'pair'): ?>
      <div class="row-2">
        <?php foreach ($block['images'] as $img): ?>
          <img src="<?= e(url($img['src'])) ?>" alt="<?= e($img['alt']) ?>" loading="lazy" decoding="async" />
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  <?php endforeach; ?>
</section>

<section class="project-meta">
  <p>
    <?= e($project['location']) ?> ·
    <a href="<?= e(url($categoryHref)) ?>"><?= e($categoryLabel) ?></a> ·
    <?= e((string)$project['year']) ?>
  </p>
</section>

<section class="project-index">
  <h2>Index</h2>
  <div class="project-index__grid">
    <?php
    $index = 1;
    foreach ($project['gallery'] as $block):
      $images = $block['kind'] === 'full' ? [['src' => $block['src']]] : $block['images'];
      foreach ($images as $img):
    ?>
      <div class="project-index__item">
        <img src="<?= e(url($img['src'])) ?>" alt="" loading="lazy" decoding="async" />
        <p><?= str_pad((string)$index++, 2, '0', STR_PAD_LEFT) ?></p>
      </div>
    <?php endforeach; endforeach; ?>
  </div>
</section>

<?php require __DIR__ . '/../_inc/footer.php'; ?>
