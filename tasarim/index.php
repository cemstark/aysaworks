<?php
$root = '../';
require __DIR__ . '/../_inc/site.php';
require __DIR__ . '/../_inc/designs.php';

$pageTitle = 'Mobilya/Obje Tasarımları — ' . $site['name'];
$pageDescription = 'Aysa Works mobilya ve obje tasarımları: mekana özel mobilyalar, seramik, pirinç, cam, doğal taş ve tekstil parçaları.';
$pageCanonical = 'tasarim/index.php';
$pageImage = 'images/yatakodasi3.webp';
$items = $designs;

require __DIR__ . '/../_inc/header.php';
?>

<section class="project-hero">
  <h1>Mobilya/Obje</h1>
  <p>Mekanın parçası olarak tasarlanan mobilyalar ve küçük ölçekli objeler; doğal malzeme, oran ve kullanım hissi üzerinden birlikte ele alınır.</p>
</section>

<section class="projects">
  <div class="project-grid project-grid--3">
    <?php foreach ($items as $d): ?>
      <a class="project-card" href="#">
        <div class="project-card__img">
          <?= responsive_img($d['cover'], $d['title'], '(max-width: 900px) 50vw, 33vw', ['loading' => 'lazy']) ?>
        </div>
        <h3 class="project-card__title"><?= e($d['title']) ?></h3>
        <p class="project-card__meta"><?= e($d['sub']) ?> · <?= e((string)$d['year']) ?></p>
      </a>
    <?php endforeach; ?>
  </div>
</section>

<?php require __DIR__ . '/../_inc/footer.php'; ?>
