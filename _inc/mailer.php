<?php
declare(strict_types=1);

use PHPMailer\PHPMailer\PHPMailer;

function phpmailer_available(): bool
{
    $base = __DIR__ . '/../vendor/phpmailer/phpmailer/src/';
    if (!is_file($base . 'Exception.php') || !is_file($base . 'PHPMailer.php') || !is_file($base . 'SMTP.php')) {
        return false;
    }

    require_once $base . 'Exception.php';
    require_once $base . 'PHPMailer.php';
    require_once $base . 'SMTP.php';

    return class_exists(PHPMailer::class);
}

function inquiry_native_mail(array $site, array $data): void
{
    $clientName = trim($data['first_name'] . ' ' . $data['last_name']);
    $lines = inquiry_rows($data);
    $body = "Yeni proje talebi\n\n" . implode("\n", $lines);
    $headers = [
        'MIME-Version: 1.0',
        'Content-Type: text/plain; charset=UTF-8',
        'From: ' . $site['name'] . ' <' . $site['email'] . '>',
        'Reply-To: ' . $clientName . ' <' . $data['email'] . '>',
    ];

    if (!mail($site['email'], 'Yeni proje talebi - ' . $clientName, $body, implode("\r\n", $headers))) {
        throw new RuntimeException('PHP mail() gönderimi başarısız oldu.');
    }
}

function inquiry_rows(array $data): array
{
    $clientName = trim($data['first_name'] . ' ' . $data['last_name']);
    $rows = [
        'Ad Soyad' => $clientName,
        'Telefon' => $data['phone'],
        'E-posta' => $data['email'],
        'Proje adresi / lokasyon' => $data['property_address'],
        'Alan' => $data['square_footage'],
        'Oda sayısı' => $data['bedrooms'],
        'Banyo sayısı' => $data['bathrooms'],
        'Başlangıç tarihi' => $data['start_date'],
        'Hedef tamamlanma' => $data['completion_date'],
        'İnşaat bütçesi' => $data['construction_budget'],
        'Mobilya & dekor bütçesi' => $data['furniture_budget'],
        'İş kapsamı' => $data['scope'],
        'Ek notlar' => $data['message'],
    ];

    $lines = [];
    foreach ($rows as $label => $value) {
        $cleanValue = trim((string)$value);
        if ($cleanValue !== '') {
            $lines[] = $label . ': ' . $cleanValue;
        }
    }

    return $lines;
}

function site_mailer(array $site)
{
    $mail = new PHPMailer(true);
    $mail->CharSet = 'UTF-8';
    $mail->Encoding = 'base64';

    $host = trim((string)getenv('MAIL_HOST'));
    if ($host !== '') {
        $mail->isSMTP();
        $mail->Host = $host;
        $mail->Port = (int)(getenv('MAIL_PORT') ?: 587);
        $username = (string)getenv('MAIL_USERNAME');
        $password = (string)getenv('MAIL_PASSWORD');
        $mail->SMTPAuth = $username !== '' || $password !== '';
        $mail->Username = $username;
        $mail->Password = $password;

        $encryption = strtolower((string)(getenv('MAIL_ENCRYPTION') ?: 'tls'));
        if ($encryption === 'ssl' || $encryption === 'smtps') {
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        } elseif ($encryption === 'tls' || $encryption === 'starttls') {
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        }
    } else {
        $mail->isMail();
    }

    $from = trim((string)(getenv('MAIL_FROM') ?: $site['email']));
    $fromName = trim((string)(getenv('MAIL_FROM_NAME') ?: $site['name']));
    $mail->setFrom($from, $fromName);

    return $mail;
}

function inquiry_send(array $site, array $data): void
{
    if (!phpmailer_available()) {
        inquiry_native_mail($site, $data);
        return;
    }

    $mail = site_mailer($site);
    $recipient = $site['email'];
    $clientName = trim($data['first_name'] . ' ' . $data['last_name']);

    $mail->addAddress($recipient, $site['name']);
    $mail->addReplyTo($data['email'], $clientName);
    $mail->Subject = 'Yeni proje talebi - ' . $clientName;
    $mail->isHTML(true);

    $htmlRows = '';
    foreach (inquiry_rows($data) as $line) {
        [$label, $cleanValue] = explode(': ', $line, 2);
        if ($cleanValue === '') {
            continue;
        }
        $htmlRows .= '<tr><th style="text-align:left;padding:8px 12px;border-bottom:1px solid #ddd;">'
            . htmlspecialchars($label, ENT_QUOTES | ENT_HTML5, 'UTF-8')
            . '</th><td style="padding:8px 12px;border-bottom:1px solid #ddd;">'
            . nl2br(htmlspecialchars($cleanValue, ENT_QUOTES | ENT_HTML5, 'UTF-8'))
            . '</td></tr>';
    }

    $mail->Body = '<h2>Yeni proje talebi</h2><table cellspacing="0" cellpadding="0" style="border-collapse:collapse;width:100%;max-width:720px;">'
        . $htmlRows
        . '</table>';
    $mail->AltBody = "Yeni proje talebi\n\n" . implode("\n", inquiry_rows($data));
    $mail->send();
}
