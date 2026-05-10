<?php
$root = '../';
require __DIR__ . '/../_inc/site.php';
require __DIR__ . '/../_inc/designs.php';

$pageTitle = 'Obje — ' . $site['name'];
$pageDescription = 'Aysa Works obje tasarımları: seramik, pirinç, cam, doğal taş ve tekstil parçalarıyla mekana karakter katan tasarım objeleri.';
$pageCanonical = 'tasarim/obje.php';
$pageImage = 'images/image00009.webp';
$items = designs_by_category($designs, 'obje');

require __DIR__ . '/../_inc/header.php';
?>

<section class="project-hero">
  <h1>Obje</h1>
  <p>Vazo, ayna, tepsi ve aydınlatma gibi küçük ölçekli tasarımlar — günlük kullanımda dokunmayı, bakmayı ve yavaşlamayı hatırlatan parçalar.</p>
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
