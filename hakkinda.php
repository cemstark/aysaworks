<?php
$root = './';
require __DIR__ . '/_inc/site.php';
$pageTitle = 'Hakkında — ' . $site['name'];
require __DIR__ . '/_inc/header.php';
?>

<section class="about-section">
  <div class="about-grid">
    <img src="<?= e(url('images/aysa-portrait.jpeg')) ?>" alt="Aysa Yağız" />
    <div class="about-text">
      <p class="eyebrow">Stüdyo</p>
      <h1><?= e($site['name']) ?> hakkında</h1>
      <p><?= e($site['name']) ?>; iç mimar Aysa Yağız tarafından <?= e($site['city']) ?>'da kurulan, konut ve ticari iç mekânlar ile özel mobilya ve obje tasarımı yapan bir tasarım stüdyosudur.</p>
      <p>Stüdyo; her projeyi kullanıcısının yaşam ritmini esas alan, malzemeyi öne koyan ve zamana karşı duran bir bütünlükle ele alır. Tasarım kararları; ışık, oran, doku ve doğal malzeme üzerinden kurulur — sade, dürüst ve sessiz.</p>
      <p>İşbirliği yaptığımız usta zanaatkârlarla; mobilyadan armatüre, dolaptan dokumaya kadar mekânın bütününü tek bir dilden konuşturmaya çalışıyoruz.</p>
    </div>
  </div>
</section>

<?php require __DIR__ . '/_inc/footer.php'; ?>
