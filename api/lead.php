<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');
header('Cache-Control: no-store');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'error' => 'method_not_allowed']);
    exit;
}

$configPath = __DIR__ . '/../config.php';
$cfg = file_exists($configPath) ? require $configPath : require __DIR__ . '/../config.example.php';

function clean(string $s, int $max = 250): string {
    $s = trim(strip_tags($s));
    $s = preg_replace('/[\r\n\t]+/u', ' ', $s);
    $s = preg_replace('/\s{2,}/u', ' ', $s);
    if (mb_strlen($s) > $max) {
        $s = mb_substr($s, 0, $max);
    }
    return $s;
}

// Honeypot
if (!empty($_POST['company_url'])) {
    echo json_encode(['ok' => true]);
    exit;
}

// Min form-fill time
$ts = (int)($_POST['ts'] ?? 0);
$elapsed = time() - $ts;
$minTime = (int)($cfg['min_form_time'] ?? 2);
if ($ts > 0 && $elapsed < $minTime) {
    echo json_encode(['ok' => true]);
    exit;
}

$name      = clean((string)($_POST['name'] ?? ''), 120);
$phoneRaw  = clean((string)($_POST['phone'] ?? ''), 60);
$messenger = clean((string)($_POST['messenger'] ?? ''), 40);
$lang      = preg_match('/^[a-z]{2}$/', (string)($_POST['lang'] ?? '')) ? $_POST['lang'] : 'uk';
$policy    = !empty($_POST['policy']);

$phone = preg_replace('/[^\d+\s\-()]/u', '', $phoneRaw);

if ($name === '' || $phone === '' || !$policy) {
    http_response_code(422);
    echo json_encode(['ok' => false, 'error' => 'validation']);
    exit;
}

$ip       = $_SERVER['HTTP_CF_CONNECTING_IP'] ?? $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? '';
$ip       = clean((string)$ip, 60);
$ua       = clean((string)($_SERVER['HTTP_USER_AGENT'] ?? ''), 200);
$referer  = clean((string)($_SERVER['HTTP_REFERER'] ?? ''), 200);
$now      = date('Y-m-d H:i:s');

/* ---------- Compose Telegram message ---------- */
$tgLines = [
    '🔔 *New Axiom lead*',
    '',
    '*Name:* ' . tg_escape($name),
    '*Phone:* ' . tg_escape($phone),
    '*Messenger:* ' . tg_escape($messenger ?: '—'),
    '*Lang:* ' . strtoupper($lang),
    '',
    '`' . tg_escape($now . ' · ' . $ip) . '`',
    'UA: ' . tg_escape(mb_substr($ua, 0, 80)),
];
$tgMsg = implode("\n", $tgLines);

$tgOk = true;
if (!empty($cfg['telegram']['enabled'])) {
    $tgOk = false;
    $token = (string)($cfg['telegram']['token'] ?? '');
    $ids   = (array) ($cfg['telegram']['chat_ids'] ?? []);
    if ($token && $ids) {
        foreach ($ids as $cid) {
            $cid = trim((string)$cid);
            if ($cid === '') continue;
            $sent = tg_send($token, $cid, $tgMsg);
            if ($sent) $tgOk = true;
        }
    }
}

/* ---------- Email ---------- */
$emailOk = true;
if (!empty($cfg['email']['enabled'])) {
    $emailOk = false;
    $to   = $cfg['email']['to'] ?? [];
    $from = (string)($cfg['email']['from'] ?? '');
    $subj = (string)($cfg['email']['subject'] ?? 'Lead');
    if ($to && $from) {
        $body  = "Нова заявка з axiom-technology.eu\n\n";
        $body .= "Ім’я: $name\n";
        $body .= "Телефон: $phone\n";
        $body .= "Месенджер: " . ($messenger ?: '—') . "\n";
        $body .= "Мова: " . strtoupper($lang) . "\n\n";
        $body .= "Час: $now\n";
        $body .= "IP: $ip\n";
        $body .= "User-Agent: $ua\n";
        $body .= "Referer: $referer\n";

        $headers  = "From: Axiom site <$from>\r\n";
        $headers .= "Reply-To: $from\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion();

        foreach ((array)$to as $addr) {
            $addr = trim((string)$addr);
            if ($addr === '') continue;
            if (@mail($addr, '=?UTF-8?B?' . base64_encode($subj) . '?=', $body, $headers)) {
                $emailOk = true;
            }
        }
    }
}

/* ---------- Log fallback ---------- */
if (!empty($cfg['log']['enabled'])) {
    $logPath = (string)($cfg['log']['path'] ?? '');
    if ($logPath !== '') {
        $dir = dirname($logPath);
        if (!is_dir($dir)) @mkdir($dir, 0775, true);
        $line = json_encode([
            'time' => $now,
            'name' => $name, 'phone' => $phone, 'messenger' => $messenger,
            'lang' => $lang, 'ip' => $ip, 'ua' => $ua, 'referer' => $referer,
            'tg_ok' => $tgOk, 'email_ok' => $emailOk,
        ], JSON_UNESCAPED_UNICODE);
        @file_put_contents($logPath, $line . PHP_EOL, FILE_APPEND | LOCK_EX);
    }
}

if (!$tgOk && !$emailOk) {
    http_response_code(502);
    echo json_encode(['ok' => false, 'error' => 'delivery_failed']);
    exit;
}

echo json_encode(['ok' => true]);
exit;


/* ---------- Helpers ---------- */
function tg_escape(string $s): string {
    return str_replace(['\\', '_', '*', '`', '[', ']'], ['\\\\', '\\_', '\\*', '\\`', '\\[', '\\]'], $s);
}
function tg_send(string $token, string $chatId, string $text): bool {
    $url = "https://api.telegram.org/bot{$token}/sendMessage";
    $payload = [
        'chat_id' => $chatId,
        'text' => $text,
        'parse_mode' => 'Markdown',
        'disable_web_page_preview' => true,
    ];
    if (function_exists('curl_init')) {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($payload),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 8,
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_SSL_VERIFYPEER => true,
        ]);
        $res = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return $code === 200 && $res && strpos((string)$res, '"ok":true') !== false;
    }
    // Fallback: file_get_contents
    $ctx = stream_context_create([
        'http' => [
            'method' => 'POST',
            'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
            'content' => http_build_query($payload),
            'timeout' => 8,
            'ignore_errors' => true,
        ]
    ]);
    $res = @file_get_contents($url, false, $ctx);
    return $res !== false && strpos((string)$res, '"ok":true') !== false;
}
