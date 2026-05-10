<?php
$root = '../';
require __DIR__ . '/../_inc/site.php';
require __DIR__ . '/../_inc/designs.php';

$pageTitle = 'Mobilya — ' . $site['name'];
$pageDescription = 'Aysa Works mobilya tasarımları: mekana özel, doğal malzeme ve oran odaklı karyola, sehpa, modül ve özel üretim mobilyalar.';
$pageCanonical = 'tasarim/mobilya.php';
$pageImage = 'images/yatakodasi3.webp';
$items = designs_by_category($designs, 'mobilya');

require __DIR__ . '/../_inc/header.php';
?>

<section class="project-hero">
  <h1>Mobilya</h1>
  <p>Mekânın bir parçası olarak ya da bağımsız ürün olarak tasarlanan; doğal malzemenin elini, oranın sakinliğini ve kullanımın doğruluğunu önemseyen mobilyalar.</p>
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
