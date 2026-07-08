<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>予約くん</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="./js/default.js"></script>
</head>

<body>

<div class="container py-5">

    <h1 class="mb-4">予約くん</h1>

    <div class="card shadow-sm">
        <div class="card-body">

            <div class="mb-3">
                <label class="form-label">予約タイトル</label>
                <input type="text"
                       id="title"
                       class="form-control"
                       placeholder="英会話体験レッスン">
            </div>

            <div class="mb-3">
                <label class="form-label">説明（任意）</label>
                <textarea id="description"
                          class="form-control"
                          rows="3"></textarea>
            </div>

            <hr>

            <h5>予約枠</h5>

            <div id="slot-container">

                <div class="slot-row mb-3 d-flex gap-2">

                    <input
                        type="datetime-local"
                        class="form-control slot-input">

                    <button
                        type="button"
                        class="btn btn-outline-danger remove-slot px-3 text-nowrap">

                        <i class="bi bi-trash"></i> 削除

                    </button>

                </div>

            </div>

            <button
                type="button"
                class="btn btn-outline-primary"
                id="add-slot">

                ＋予約枠を追加

            </button>

            <button
                    class="btn btn-primary"
                    id="createBtn"
                    disabled>
                予約ページを作成する
            </button>

        </div>
    </div>

    <div class="mt-4" id="result"></div>

</div>

</body>
</html>
