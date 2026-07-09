<?php

$id = $_GET['id'] ?? '';

$file = "data/{$id}.json";

if (!file_exists($file)) {
    die('予約データが見つかりません。');
}

$data = json_decode(
    file_get_contents($file),
    true
);

if (!$data) {
    die('JSONの読み込みに失敗しました。');
}

$totalSlots = count($data['slots']);

$reservedCount = 0;

foreach ($data['slots'] as $slot) {
    if ($slot['reserved']) {
        $reservedCount++;
    }
}

$availableCount = $totalSlots - $reservedCount;

?>

<!DOCTYPE html>
<html lang="ja">

<head>

<meta charset="UTF-8">

<title>
管理画面 -
<?= htmlspecialchars($data['title']) ?>
</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
rel="stylesheet">

</head>

<body>

<div class="container py-5">

    <div class="card shadow">

        <div class="card-body">

            <h1 class="mb-3">
                <?= htmlspecialchars($data['title']) ?>
            </h1>

            <?php if (!empty($data['description'])): ?>

                <p class="text-muted">
                    <?= nl2br(htmlspecialchars($data['description'])) ?>
                </p>

            <?php endif; ?>

            <hr>

            <div class="row text-center mb-4">

                <div class="col-md-4">

                    <div class="card border-primary">

                        <div class="card-body">

                            <h2>
                                <?= $totalSlots ?>
                            </h2>

                            <div>予約枠</div>

                        </div>

                    </div>

                </div>

                <div class="col-md-4">

                    <div class="card border-success">

                        <div class="card-body">

                            <h2>
                                <?= $reservedCount ?>
                            </h2>

                            <div>予約済み</div>

                        </div>

                    </div>

                </div>

                <div class="col-md-4">

                    <div class="card border-warning">

                        <div class="card-body">

                            <h2>
                                <?= $availableCount ?>
                            </h2>

                            <div>空き枠</div>

                        </div>

                    </div>

                </div>

            </div>

            <?php foreach ($data['slots'] as $slot): ?>

                <div class="card mb-3">

                    <div class="card-body">

                        <div class="row align-items-center">

                            <div class="col-md-5">

                                <h5 class="mb-0">

                                    <?= date(
                                        'Y年n月j日 G:i',
                                        strtotime($slot['time'])
                                    ) ?>

                                </h5>

                            </div>

                            <div class="col-md-4">

                                <?php if ($slot['reserved']): ?>

                                    <strong>
                                        <?= htmlspecialchars($slot['name']) ?>
                                    </strong>

                                    <?php if ($slot['email'] !== ''): ?>

                                        <div class="small text-muted">
                                            <?= htmlspecialchars($slot['email']) ?>
                                        </div>

                                    <?php endif; ?>

                                <?php else: ?>

                                    <span class="text-muted">
                                        空き
                                    </span>

                                <?php endif; ?>

                            </div>

                            <div class="col-md-3 text-end">

                                <?php if ($slot['reserved']): ?>

                                    <span class="badge bg-success mb-2">
                                        予約済み
                                    </span>

                                    <form
                                        action="admin_cancel.php"
                                        method="post">

                                        <input
                                            type="hidden"
                                            name="id"
                                            value="<?= htmlspecialchars($id) ?>">

                                        <input
                                            type="hidden"
                                            name="slot_id"
                                            value="<?= $slot['slot_id'] ?>">

                                        <button
                                            type="submit"
                                            class="btn btn-danger btn-sm">

                                            キャンセル

                                        </button>

                                    </form>

                                <?php else: ?>

                                    <span class="badge bg-warning text-dark">
                                        空き
                                    </span>

                                <?php endif; ?>

                            </div>

                        </div>

                    </div>

                </div>

            <?php endforeach; ?>

        </div>

    </div>

</div>

</body>
</html>
