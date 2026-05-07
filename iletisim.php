<?php
$root = './';
require __DIR__ . '/_inc/site.php';
$pageTitle = 'İletişim — ' . $site['name'];
require __DIR__ . '/_inc/header.php';
?>

<section class="contact-section">
  <p class="eyebrow">İletişim</p>
  <h1>Birlikte çalışalım</h1>
  <p>Yeni projeler, danışmanlık ve özel üretim talepleri için bize yazabilirsiniz. Genelde 2 iş günü içinde dönüş yaparız.</p>

  <ul class="contact-list">
    <li>
      <strong>E-posta</strong>
      <a href="mailto:<?= e($site['email']) ?>"><?= e($site['email']) ?></a>
    </li>
    <li>
      <strong>Stüdyo</strong>
      <?= e($site['city']) ?>, Türkiye<br/>
      Pazartesi – Cuma · 10:00 – 18:00
    </li>
    <li>
      <strong>Sosyal</strong>
      <a href="<?= e($site['instagram']) ?>" target="_blank" rel="noopener">Instagram</a>
    </li>
  </ul>
</section>

<?php require __DIR__ . '/_inc/footer.php'; ?>
