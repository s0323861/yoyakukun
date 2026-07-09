<?php

header('Content-Type: application/json; charset=UTF-8');

/*
|--------------------------------------------------------------------------
| 入力取得
|--------------------------------------------------------------------------
*/

$title = trim($_POST['title'] ?? '');
$description = trim($_POST['description'] ?? '');

$slots = [];

$slots = $_POST['slots'] ?? [];

/*
|--------------------------------------------------------------------------
| 簡単な入力チェック
|--------------------------------------------------------------------------
*/

if ($title === '') {
    http_response_code(400);

    echo json_encode([
        'error' => 'タイトルを入力してください。'
    ], JSON_UNESCAPED_UNICODE);

    exit;
}

if (count($slots) === 0) {
    http_response_code(400);

    echo json_encode([
        'error' => '予約枠を1つ以上入力してください。'
    ], JSON_UNESCAPED_UNICODE);

    exit;
}

/*
|--------------------------------------------------------------------------
| イベントID生成
|--------------------------------------------------------------------------
*/

do {

    $eventId = bin2hex(random_bytes(4));

} while (file_exists("data/{$eventId}.json"));

/*
|--------------------------------------------------------------------------
| JSONデータ作成
|--------------------------------------------------------------------------
*/

$data = [
    'id' => $eventId,
    'title' => $title,
    'description' => $description,
    'created_at' => date('Y-m-d H:i:s'),
    'slots' => []
];

$counter = 1;

foreach ($slots as $slot) {

    $data['slots'][] = [
        'slot_id' => $counter,
        'time' => $slot,

        'reserved' => false,

        'name' => '',
        'email' => '',

        'cancel_token' => '',

        'reserved_at' => '',

        'memo' => ''
    ];

    $counter++;
}

/*
|--------------------------------------------------------------------------
| 保存
|--------------------------------------------------------------------------
*/

if (!is_dir('data')) {
    mkdir('data', 0777, true);
}

$json = json_encode(
    $data,
    JSON_PRETTY_PRINT |
    JSON_UNESCAPED_UNICODE |
    JSON_UNESCAPED_SLASHES
);

file_put_contents(
    "data/{$eventId}.json",
    $json,
    LOCK_EX
);

/*
|--------------------------------------------------------------------------
| URL返却
|--------------------------------------------------------------------------
*/

$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https'
    ? 'https'
    : 'http';
$host = $_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME'] ?? 'localhost';
$scriptDir = dirname($_SERVER['SCRIPT_NAME'] ?? '');
$basePath = $scriptDir === '/' || $scriptDir === '.' ? '' : $scriptDir;

$url = $scheme . '://' . $host . $basePath . '/reserve.php?id=' . urlencode($eventId);
$adminUrl = $scheme . '://' . $host . $basePath . '/admin.php?id=' . urlencode($eventId);

echo json_encode([
    'url' => $url,
    'admin_url' => $adminUrl
], JSON_UNESCAPED_UNICODE);

?>
