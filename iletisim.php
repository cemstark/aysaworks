<?php
session_start();

$root = './';
require __DIR__ . '/_inc/site.php';
$pageTitle = 'İletişim — ' . $site['name'];
$errors = $_SESSION['contact_errors'] ?? [];
$success = (bool)($_SESSION['contact_success'] ?? false);
$old = $_SESSION['contact_old'] ?? [];
unset($_SESSION['contact_errors'], $_SESSION['contact_success']);

$projectTypes = [
    'konut' => 'Konut',
    'ticari' => 'Ticari mekan',
    'mobilya' => 'Mobilya',
    'obje' => 'Obje',
];
$selectedProjectType = (string)($old['project_type'] ?? 'konut');
if (!isset($projectTypes[$selectedProjectType])) {
    $selectedProjectType = 'konut';
}

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

      <fieldset class="project-type-fieldset">
        <legend>Proje türü</legend>
        <div class="project-type-options">
          <?php foreach ($projectTypes as $value => $label): ?>
            <label class="project-type-option">
              <input type="radio" name="project_type" value="<?= e($value) ?>"<?= $selectedProjectType === $value ? ' checked' : '' ?> />
              <span><?= e($label) ?></span>
            </label>
          <?php endforeach; ?>
        </div>
      </fieldset>

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
        <label class="form-wide" data-projects="konut ticari">
          <span>Proje adresi / lokasyon</span>
          <input type="text" name="property_address" autocomplete="street-address" value="<?= old_value($old, 'property_address') ?>" />
        </label>
        <label data-projects="konut ticari">
          <span>Alan*</span>
          <input type="text" name="square_footage" placeholder="Örn. 180 m²" value="<?= old_value($old, 'square_footage') ?>" required />
        </label>
        <label data-projects="konut">
          <span>Oda sayısı</span>
          <input type="text" name="bedrooms" value="<?= old_value($old, 'bedrooms') ?>" />
        </label>
        <label data-projects="konut">
          <span>Banyo sayısı</span>
          <input type="text" name="bathrooms" value="<?= old_value($old, 'bathrooms') ?>" />
        </label>
        <label data-projects="mobilya obje">
          <span>Ürün tipi*</span>
          <input type="text" name="item_type" placeholder="Örn. yemek masası, aydınlatma" value="<?= old_value($old, 'item_type') ?>" />
        </label>
        <label data-projects="mobilya obje">
          <span>Ölçü / adet</span>
          <input type="text" name="dimensions" placeholder="Örn. 220 x 90 cm, 4 adet" value="<?= old_value($old, 'dimensions') ?>" />
        </label>
        <label class="form-wide" data-projects="mobilya obje">
          <span>Malzeme tercihi</span>
          <input type="text" name="material_preference" placeholder="Örn. ceviz, traverten, pirinç" value="<?= old_value($old, 'material_preference') ?>" />
        </label>
        <label>
          <span>Başlangıç tarihi</span>
          <input type="text" name="start_date" placeholder="GG/AA/YYYY" value="<?= old_value($old, 'start_date') ?>" />
        </label>
        <label>
          <span>Hedef tamamlanma</span>
          <input type="text" name="completion_date" placeholder="GG/AA/YYYY" value="<?= old_value($old, 'completion_date') ?>" />
        </label>
        <label data-projects="konut ticari">
          <span>İnşaat bütçesi</span>
          <input type="text" name="construction_budget" value="<?= old_value($old, 'construction_budget') ?>" />
        </label>
        <label>
          <span data-label-konut="Mobilya & dekor bütçesi" data-label-ticari="Mobilya & dekor bütçesi" data-label-mobilya="Mobilya bütçesi" data-label-obje="Obje bütçesi">Mobilya & dekor bütçesi</span>
          <input type="text" name="furniture_budget" value="<?= old_value($old, 'furniture_budget') ?>" />
        </label>
        <label class="form-wide">
          <span data-label-konut="İş kapsamı*" data-label-ticari="İş kapsamı*" data-label-mobilya="Tasarım talebi*" data-label-obje="Tasarım talebi*">İş kapsamı*</span>
          <textarea name="scope" rows="5" required><?= old_value($old, 'scope') ?></textarea>
        </label>
        <label class="form-wide">
          <span>Ek sorular ve notlar</span>
          <textarea name="message" rows="4"><?= old_value($old, 'message') ?></textarea>
        </label>
      </div>

      <button class="form-submit" type="submit">Talebi gönder</button>
    </form>
  </div>
</section>

<?php require __DIR__ . '/_inc/footer.php'; ?>
