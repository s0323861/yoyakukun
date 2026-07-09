<?php

$token = $_GET['token'] ?? '';

if ($token === '') {
    die('キャンセルトークンが指定されていません。');
}

$files = glob('data/*.json');

$found = false;
$eventId = '';

foreach ($files as $file) {

    $fp = fopen($file, 'r+');

    if (!$fp) {
        continue;
    }

    flock($fp, LOCK_EX);

    $json = stream_get_contents($fp);

    $data = json_decode($json, true);

    if (!$data) {
        flock($fp, LOCK_UN);
        fclose($fp);
        continue;
    }

    foreach ($data['slots'] as &$slot) {

        if (
            $slot['reserved'] &&
            ($slot['cancel_token'] ?? '') === $token
        ) {

            $slot['reserved'] = false;
            $slot['name'] = '';
            $slot['email'] = '';
            $slot['cancel_token'] = '';
            $slot['reserved_at'] = '';

            $found = true;
            $eventId = $data['id'];

            break;
        }
    }

    if ($found) {

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

    flock($fp, LOCK_UN);

    fclose($fp);

    if ($found) {
        break;
    }
}

?>
<!DOCTYPE html>
<html lang="ja">

<head>

<meta charset="UTF-8">

<title>予約キャンセル</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
rel="stylesheet">

</head>

<body>

<div class="container py-5">

    <div class="card shadow">

        <div class="card-body text-center">

            <?php if ($found): ?>

                <div class="alert alert-success">

                    <h3>予約をキャンセルしました</h3>

                    <p>
                        ご利用ありがとうございました。
                    </p>

                </div>

                <a
                    href="reserve.php?id=<?= urlencode($eventId) ?>"
                    class="btn btn-primary">

                    予約ページへ戻る

                </a>

            <?php else: ?>

                <div class="alert alert-danger">

                    <h3>キャンセルできませんでした</h3>

                    <p>
                        このURLは無効か、すでにキャンセル済みです。
                    </p>

                </div>

            <?php endif; ?>

        </div>

    </div>

</div>

</body>
</html>