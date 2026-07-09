<?php

$id = $_POST['id'] ?? '';

$slotId = intval($_POST['slot_id'] ?? 0);

if (
    $id === '' ||
    $slotId === 0
) {
    die('入力内容に誤りがあります。');
}

$file = "data/{$id}.json";

if (!file_exists($file)) {
    die('予約データが見つかりません。');
}

$fp = fopen($file, 'r+');

if (!$fp) {
    die('ファイルを開けませんでした。');
}

flock($fp, LOCK_EX);

$json = stream_get_contents($fp);

$data = json_decode($json, true);

if (!$data) {

    flock($fp, LOCK_UN);

    fclose($fp);

    die('JSONの読み込みに失敗しました。');
}

foreach ($data['slots'] as &$slot) {

    if ($slot['slot_id'] == $slotId) {

        $slot['reserved'] = false;
        $slot['name'] = '';
        $slot['email'] = '';
        $slot['cancel_token'] = '';
        $slot['reserved_at'] = '';

        break;
    }
}

rewind($fp);

ftruncate($fp, 0);

fwrite(
    $fp,
    json_encode(
        $data,
        JSON_PRETTY_PRINT |
        JSON_UNESCAPED_UNICODE |
        JSON_UNESCAPED_SLASHES
    )
);

flock($fp, LOCK_UN);

fclose($fp);

header(
    'Location: admin.php?id=' .
    urlencode($id)
);

exit;