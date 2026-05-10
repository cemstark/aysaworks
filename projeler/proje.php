<?php
$root = '../';
require __DIR__ . '/../_inc/site.php';
require __DIR__ . '/../_inc/projects.php';

$slug = $_GET['slug'] ?? '';
$project = find_project($projects, (string)$slug);

if (!$project) {
    http_response_code(404);
    $pageTitle = 'Bulunamadı — ' . $site['name'];
    $pageDescription = 'Aradığınız Aysa Works projesi bulunamadı.';
    $robotsContent = 'noindex, follow';
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
$pageDescription = $project['intro'];
$pageCanonical = 'projeler/proje.php?slug=' . urlencode((string)$slug);
$pageImage = $project['cover'];
$pageType = 'article';
$category = $project['category'];
$categoryHref = $category === 'ticari' ? 'projeler/ticari.php' : 'projeler/konut.php';
$categoryLabel = $category === 'ticari' ? 'Ticari' : 'Konut';
$structuredData = [[
    '@type' => 'CreativeWork',
    '@id' => absolute_url($pageCanonical) . '#project',
    'name' => $project['title'],
    'description' => $project['intro'],
    'image' => absolute_url($project['cover']),
    'dateCreated' => (string)$project['year'],
    'locationCreated' => [
        '@type' => 'Place',
        'name' => $project['location'],
    ],
    'creator' => [
        '@id' => absolute_url('#organization'),
    ],
]];

require __DIR__ . '/../_inc/header.php';
?>

<section class="project-hero">
  <h1><?= e($project['title']) ?></h1>
  <p><?= e($project['intro']) ?></p>
</section>

<section class="project-gallery">
  <?php foreach ($project['gallery'] as $block): ?>
    <?php if ($block['kind'] === 'full'): ?>
      <?= responsive_img($block['src'], $block['alt'], '(max-width: 900px) calc(100vw - 40px), calc(100vw - 128px)', ['loading' => 'lazy']) ?>
    <?php elseif ($block['kind'] === 'pair'): ?>
      <div class="row-2">
        <?php foreach ($block['images'] as $img): ?>
          <?= responsive_img($img['src'], $img['alt'], '(max-width: 900px) calc(100vw - 40px), 50vw', ['loading' => 'lazy']) ?>
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
        <?= responsive_img($img['src'], '', '(max-width: 900px) 50vw, 140px', ['loading' => 'lazy']) ?>
        <p><?= str_pad((string)$index++, 2, '0', STR_PAD_LEFT) ?></p>
      </div>
    <?php endforeach; endforeach; ?>
  </div>
</section>

<?php require __DIR__ . '/../_inc/footer.php'; ?>
