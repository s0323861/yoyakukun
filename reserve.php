<?php

$id = $_GET['id'] ?? '';

$file = "data/{$id}.json";

if (!file_exists($file)) {
    die("予約ページが見つかりません。");
}

$data = json_decode(
    file_get_contents($file),
    true
);

?>

<!DOCTYPE html>
<html lang="ja">

<head>

<meta charset="UTF-8">

<title>
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

            <?php if ($data['description'] !== ''): ?>

                <p class="text-muted">
                    <?= nl2br(htmlspecialchars($data['description'])) ?>
                </p>

            <?php endif; ?>

            <hr>

            <?php foreach ($data['slots'] as $slot): ?>

                <div class="card mb-3">

                    <div class="card-body">

                        <h5>
                            <?= date(
                                'Y年n月j日 G:i',
                                strtotime($slot['time'])
                            ) ?>
                        </h5>

                        <?php if ($slot['reserved']): ?>

                            <div class="alert alert-secondary mt-3 mb-0">
                                予約済み
                            </div>

                        <?php else: ?>

                            <form action="booking.php" method="post">

                                <input
                                    type="hidden"
                                    name="id"
                                    value="<?= htmlspecialchars($id) ?>">

                                <input
                                    type="hidden"
                                    name="slot_id"
                                    value="<?= $slot['slot_id'] ?>">

                                <div class="mb-3">

                                    <input
                                        type="text"
                                        name="name"
                                        class="form-control"
                                        placeholder="お名前"
                                        required>

                                </div>

                                <button
                                    type="submit"
                                    class="btn btn-primary">

                                    予約する

                                </button>

                            </form>

                        <?php endif; ?>

                    </div>

                </div>

            <?php endforeach; ?>

        </div>

    </div>

</div>

</body>
</html>