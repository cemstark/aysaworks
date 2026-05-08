<?php
session_start();

$root = './';
require __DIR__ . '/_inc/site.php';
$pageTitle = 'İletişim — ' . $site['name'];
$errors = $_SESSION['contact_errors'] ?? [];
$success = (bool)($_SESSION['contact_success'] ?? false);
$old = $_SESSION['contact_old'] ?? [];
unset($_SESSION['contact_errors'], $_SESSION['contact_success']);

if (empty($_SESSION['contact_csrf'])) {
    $_SESSION['contact_csrf'] = bin2hex(random_bytes(32));
}

function old_value(array $old, string $key): string
{
    return e((string)($old[$key] ?? ''));
}

require __DIR__ . '/_inc/header.php';
?>

<section class="contact-section" id="inquiry">
  <div class="contact-intro">
    <h1>Birlikte çalışalım</h1>
    <p>Konut, ticari mekân, mobilya ve obje tasarımı talepleriniz için proje bilgilerinizi paylaşın. Başvurunuzu inceleyip genelde 2 iş günü içinde dönüş yaparız.</p>
  </div>

  <div class="contact-layout">
    <aside class="contact-details" aria-label="İletişim bilgileri">
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
    </aside>

    <form class="inquiry-form" action="<?= e(url('contact-submit.php')) ?>" method="post" novalidate>
      <input type="hidden" name="csrf_token" value="<?= e($_SESSION['contact_csrf']) ?>" />
      <label class="form-hp" aria-hidden="true">Website <input type="text" name="website" tabindex="-1" autocomplete="off" /></label>

      <?php if ($success): ?>
        <p class="form-alert form-alert--success">Talebiniz alındı. En kısa sürede sizinle iletişime geçeceğiz.</p>
      <?php endif; ?>

      <?php if ($errors): ?>
        <div class="form-alert form-alert--error" role="alert">
          <?php foreach ($errors as $error): ?>
            <p><?= e((string)$error) ?></p>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

      <div class="form-grid">
        <label>
          <span>Ad*</span>
          <input type="text" name="first_name" autocomplete="given-name" value="<?= old_value($old, 'first_name') ?>" required />
        </label>
        <label>
          <span>Soyad*</span>
          <input type="text" name="last_name" autocomplete="family-name" value="<?= old_value($old, 'last_name') ?>" required />
        </label>
        <label>
          <span>Telefon</span>
          <input type="tel" name="phone" autocomplete="tel" value="<?= old_value($old, 'phone') ?>" />
        </label>
        <label>
          <span>E-posta*</span>
          <input type="email" name="email" autocomplete="email" value="<?= old_value($old, 'email') ?>" required />
        </label>
        <label class="form-wide">
          <span>Proje adresi / lokasyon</span>
          <input type="text" name="property_address" autocomplete="street-address" value="<?= old_value($old, 'property_address') ?>" />
        </label>
        <label>
          <span>Alan*</span>
          <input type="text" name="square_footage" placeholder="Örn. 180 m²" value="<?= old_value($old, 'square_footage') ?>" required />
        </label>
        <label>
          <span>Oda sayısı</span>
          <input type="text" name="bedrooms" value="<?= old_value($old, 'bedrooms') ?>" />
        </label>
        <label>
          <span>Banyo sayısı</span>
          <input type="text" name="bathrooms" value="<?= old_value($old, 'bathrooms') ?>" />
        </label>
        <label>
          <span>Başlangıç tarihi</span>
          <input type="text" name="start_date" placeholder="GG/AA/YYYY" value="<?= old_value($old, 'start_date') ?>" />
        </label>
        <label>
          <span>Hedef tamamlanma</span>
          <input type="text" name="completion_date" placeholder="GG/AA/YYYY" value="<?= old_value($old, 'completion_date') ?>" />
        </label>
        <label>
          <span>İnşaat bütçesi</span>
          <input type="text" name="construction_budget" value="<?= old_value($old, 'construction_budget') ?>" />
        </label>
        <label>
          <span>Mobilya & dekor bütçesi</span>
          <input type="text" name="furniture_budget" value="<?= old_value($old, 'furniture_budget') ?>" />
        </label>
        <label class="form-wide">
          <span>İş kapsamı*</span>
          <textarea name="scope" rows="5" required><?= old_value($old, 'scope') ?></textarea>
        </label>
        <label class="form-wide">
          <span>Ek sorular ve notlar</span>
          <textarea name="message" rows="4"><?= old_value($old, 'message') ?></textarea>
        </label>
      </div>

      <button class="form-submit" type="submit">Talebi gönder</button>
      <p class="form-note">Form doğrudan <?= e($site['email']) ?> adresine iletilir.</p>
    </form>
  </div>
</section>

<?php require __DIR__ . '/_inc/footer.php'; ?>
