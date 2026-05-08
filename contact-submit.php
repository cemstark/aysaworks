<?php
declare(strict_types=1);

session_start();

$root = './';
require __DIR__ . '/_inc/site.php';
require __DIR__ . '/_inc/mailer.php';

function redirect_contact(): never
{
    header('Location: iletisim.php#inquiry');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect_contact();
}

$token = (string)($_POST['csrf_token'] ?? '');
if ($token === '' || !hash_equals((string)($_SESSION['contact_csrf'] ?? ''), $token)) {
    $_SESSION['contact_errors'] = ['Form süresi doldu. Lütfen tekrar deneyin.'];
    redirect_contact();
}

if (trim((string)($_POST['website'] ?? '')) !== '') {
    $_SESSION['contact_success'] = true;
    redirect_contact();
}

$fields = [
    'first_name',
    'last_name',
    'phone',
    'email',
    'property_address',
    'square_footage',
    'bedrooms',
    'bathrooms',
    'start_date',
    'completion_date',
    'construction_budget',
    'furniture_budget',
    'scope',
    'message',
];

$data = [];
foreach ($fields as $field) {
    $value = trim((string)($_POST[$field] ?? ''));
    $limit = $field === 'message' || $field === 'scope' ? 3000 : 180;
    $data[$field] = function_exists('mb_substr') ? mb_substr($value, 0, $limit) : substr($value, 0, $limit);
}

$errors = [];
foreach (['first_name' => 'Ad', 'last_name' => 'Soyad', 'email' => 'E-posta', 'square_footage' => 'Alan', 'scope' => 'İş kapsamı'] as $field => $label) {
    if ($data[$field] === '') {
        $errors[] = $label . ' alanı zorunludur.';
    }
}

if ($data['email'] !== '' && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Geçerli bir e-posta adresi yazın.';
}

$_SESSION['contact_old'] = $data;

if ($errors) {
    $_SESSION['contact_errors'] = $errors;
    redirect_contact();
}

try {
    inquiry_send($site, $data);
    unset($_SESSION['contact_old']);
    $_SESSION['contact_success'] = true;
} catch (Throwable $e) {
    error_log('Aysa Works inquiry mail error: ' . $e->getMessage());
    $_SESSION['contact_errors'] = ['Talebiniz şu anda gönderilemedi. Lütfen doğrudan ' . $site['email'] . ' adresine yazın.'];
}

redirect_contact();
