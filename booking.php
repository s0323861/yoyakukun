<?php

$id = $_POST['id'] ?? '';
$slotId = intval($_POST['slot_id'] ?? 0);
$name = trim($_POST['name'] ?? '');

if ($id === '' || $slotId === 0 || $name === '') {
    die('入力内容に誤りがあります。');
}

$file = "data/{$id}.json";

if (!file_exists($file)) {
    die('予約データが見つかりません。');
}

/*
|--------------------------------------------------------------------------
| 排他ロック開始
|--------------------------------------------------------------------------
*/

$fp = fopen($file, 'r+');

if (!$fp) {
    die('ファイルを開けませんでした。');
}

flock($fp, LOCK_EX);

/*
|--------------------------------------------------------------------------
| JSON読み込み
|--------------------------------------------------------------------------
*/

$json = stream_get_contents($fp);

$data = json_decode($json, true);

if (!$data) {
    flock($fp, LOCK_UN);
    fclose($fp);

    die('JSONの読み込みに失敗しました。');
}

$success = false;
$message = '';

foreach ($data['slots'] as &$slot) {

    if ($slot['slot_id'] == $slotId) {

        /*
        |--------------------------------------------------------------------------
        | すでに予約済みなら失敗
        |--------------------------------------------------------------------------
        */

        if ($slot['reserved']) {

            $message = 'この時間枠は予約済みです。';

            break;
        }

        /*
        |--------------------------------------------------------------------------
        | 予約登録
        |--------------------------------------------------------------------------
        */

        $slot['reserved'] = true;
        $slot['name'] = $name;

        $success = true;

        $message = '予約が完了しました。';

        break;
    }
}

/*
|--------------------------------------------------------------------------
| 保存
|--------------------------------------------------------------------------
*/

if ($success) {

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
}

/*
|--------------------------------------------------------------------------
| ロック解除
|--------------------------------------------------------------------------
*/

flock($fp, LOCK_UN);

fclose($fp);

?>
<!DOCTYPE html>
<html lang="ja">

<head>

<meta charset="UTF-8">

<title>予約結果</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
rel="stylesheet">

</head>

<body>

<div class="container py-5">

    <div class="card shadow">

        <div class="card-body text-center">

            <?php if ($success): ?>

                <div class="alert alert-success">

                    <h3>予約完了</h3>

                    <p class="mb-0">

                        <?= htmlspecialchars($name) ?> 様

                    </p>

                    <p class="mb-0">

                        <?= htmlspecialchars($message) ?>

                    </p>

                </div>

            <?php else: ?>

                <div class="alert alert-danger">

                    <h3>予約できませんでした</h3>

                    <p class="mb-0">

                        <?= htmlspecialchars($message) ?>

                    </p>

                </div>

            <?php endif; ?>

            <a
                href="reserve.php?id=<?= urlencode($id) ?>"
                class="btn btn-primary mt-3">

                予約ページへ戻る

            </a>

        </div>

    </div>

</div>

</body>
</html>