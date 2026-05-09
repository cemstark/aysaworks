<?php
declare(strict_types=1);

use PHPMailer\PHPMailer\PHPMailer;

function inquiry_mail_log(string $message, array $context = []): void
{
    $safeContext = [];
    foreach ($context as $key => $value) {
        if (in_array((string)$key, ['password', 'token', 'secret'], true)) {
            continue;
        }
        $safeContext[(string)$key] = is_scalar($value) ? (string)$value : gettype($value);
    }

    error_log('Aysa Works inquiry mail: ' . $message . ($safeContext ? ' ' . json_encode($safeContext, JSON_UNESCAPED_UNICODE) : ''));
}

function inquiry_project_type_label(string $projectType): string
{
    $labels = [
        'konut' => 'Konut',
        'ticari' => 'Ticari mekan',
        'mobilya' => 'Mobilya',
        'obje' => 'Obje',
    ];

    return $labels[$projectType] ?? $projectType;
}

function inquiry_header_value(string $value): string
{
    return trim(str_replace(["\r", "\n"], ' ', $value));
}

function inquiry_site_domain(array $site): string
{
    $domain = strtolower(trim((string)($site['domain'] ?? '')));
    if ($domain === '') {
        $host = strtolower((string)($_SERVER['HTTP_HOST'] ?? 'aysaworks.com'));
        $domain = preg_replace('/:\d+$/', '', $host) ?: 'aysaworks.com';
    }

    return preg_replace('/^www\./', '', $domain) ?: 'aysaworks.com';
}

function inquiry_default_from(array $site): string
{
    $username = trim((string)getenv('MAIL_USERNAME'));
    if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
        return $username;
    }

    return 'noreply@' . inquiry_site_domain($site);
}

function inquiry_recipient(array $site): string
{
    $recipient = trim((string)getenv('MAIL_TO'));

    return filter_var($recipient, FILTER_VALIDATE_EMAIL) ? $recipient : (string)$site['email'];
}

function inquiry_mail_transport(): string
{
    $host = trim((string)getenv('MAIL_HOST'));
    if ($host !== '') {
        return 'smtp';
    }

    $username = trim((string)getenv('MAIL_USERNAME'));
    $password = trim((string)getenv('MAIL_PASSWORD'));

    return $username !== '' && $password !== '' ? 'smtp' : 'php-mail';
}

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
    $clientName = inquiry_header_value(trim($data['first_name'] . ' ' . $data['last_name']));
    $lines = inquiry_rows($data);
    $body = "Yeni proje talebi\n\n" . implode("\n", $lines);
    $from = inquiry_header_value(trim((string)(getenv('MAIL_FROM') ?: inquiry_default_from($site))));
    $fromName = inquiry_header_value(trim((string)(getenv('MAIL_FROM_NAME') ?: $site['name'])));
    $replyTo = filter_var((string)$data['email'], FILTER_VALIDATE_EMAIL) ? (string)$data['email'] : $site['email'];
    $headers = [
        'MIME-Version: 1.0',
        'Content-Type: text/plain; charset=UTF-8',
        'From: ' . $fromName . ' <' . $from . '>',
        'Reply-To: ' . $clientName . ' <' . $replyTo . '>',
        'X-Mailer: Aysa Works contact form',
    ];

    inquiry_mail_log('native mail attempt', [
        'to' => inquiry_recipient($site),
        'from' => $from,
    ]);

    $params = filter_var($from, FILTER_VALIDATE_EMAIL) ? '-f' . escapeshellarg($from) : '';
    if (!function_exists('mail') || !mail(inquiry_recipient($site), 'Yeni proje talebi - ' . $clientName, $body, implode("\r\n", $headers), $params)) {
        throw new RuntimeException('PHP mail() gönderimi başarısız oldu. MAIL_HOST ile SMTP ayarı gerekli olabilir.');
    }

    inquiry_mail_log('native mail accepted', ['to' => inquiry_recipient($site)]);
}

function inquiry_rows(array $data): array
{
    $clientName = trim($data['first_name'] . ' ' . $data['last_name']);
    $rows = [
        'Proje türü' => inquiry_project_type_label((string)($data['project_type'] ?? '')),
        'Ad Soyad' => $clientName,
        'Telefon' => $data['phone'],
        'E-posta' => $data['email'],
        'Proje adresi / lokasyon' => $data['property_address'],
        'Alan' => $data['square_footage'],
        'Oda sayısı' => $data['bedrooms'],
        'Banyo sayısı' => $data['bathrooms'],
        'Ürün tipi' => $data['item_type'] ?? '',
        'Ölçü / adet' => $data['dimensions'] ?? '',
        'Malzeme tercihi' => $data['material_preference'] ?? '',
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
    $mail->Timeout = (int)(getenv('MAIL_TIMEOUT') ?: 15);
    $mail->Hostname = inquiry_site_domain($site);
    $mail->XMailer = 'Aysa Works contact form';

    $host = trim((string)getenv('MAIL_HOST'));
    $username = trim((string)getenv('MAIL_USERNAME'));
    $password = (string)getenv('MAIL_PASSWORD');
    $useSmtp = $host !== '' || ($username !== '' && $password !== '');

    if ($useSmtp) {
        $mail->isSMTP();
        $mail->Host = $host !== '' ? $host : 'smtp.hostinger.com';
        $mail->Port = (int)(getenv('MAIL_PORT') ?: 465);
        $mail->SMTPAuth = $username !== '' || $password !== '';
        $mail->Username = $username;
        $mail->Password = $password;

        $encryption = strtolower((string)(getenv('MAIL_ENCRYPTION') ?: 'ssl'));
        if ($encryption === 'ssl' || $encryption === 'smtps') {
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        } elseif ($encryption === 'tls' || $encryption === 'starttls') {
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        }

        if (filter_var(getenv('MAIL_DEBUG'), FILTER_VALIDATE_BOOLEAN)) {
            $mail->SMTPDebug = 2;
            $mail->Debugoutput = static function (string $line, int $level): void {
                inquiry_mail_log('smtp debug', ['level' => $level, 'line' => $line]);
            };
        }
    } else {
        $mail->isMail();
    }

    $from = inquiry_header_value(trim((string)(getenv('MAIL_FROM') ?: inquiry_default_from($site))));
    $fromName = inquiry_header_value(trim((string)(getenv('MAIL_FROM_NAME') ?: $site['name'])));
    $mail->setFrom($from, $fromName);
    $mail->Sender = $from;

    return $mail;
}

function inquiry_send(array $site, array $data): void
{
    if (!phpmailer_available()) {
        inquiry_native_mail($site, $data);
        return;
    }

    $mail = site_mailer($site);
    $recipient = inquiry_recipient($site);
    $clientName = inquiry_header_value(trim($data['first_name'] . ' ' . $data['last_name']));

    inquiry_mail_log('send attempt', [
        'transport' => inquiry_mail_transport(),
        'to' => $recipient,
        'from' => $mail->From,
        'subject' => 'Yeni proje talebi - ' . $clientName,
    ]);

    $mail->addAddress($recipient, $site['name']);
    if (filter_var((string)$data['email'], FILTER_VALIDATE_EMAIL)) {
        $mail->addReplyTo((string)$data['email'], $clientName);
    }
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

    inquiry_mail_log('send accepted', [
        'transport' => inquiry_mail_transport(),
        'to' => $recipient,
    ]);
}
