<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>予約くん</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="./js/default.js"></script>
</head>

<body class="bg-light">

<header class="bg-primary text-white py-5 mb-5">
    <div class="container text-center">
        <h1 class="display-4 fw-bold">予約くん</h1>
        <p class="lead mt-3">
            面談・レッスン・イベント予約を数分で作成
        </p>
        <p class="mb-0">
            会員登録不要で、すぐに予約ページを公開できます。
        </p>
    </div>
</header>

<main class="container pb-5">

    <div class="row text-center mb-5">

        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="fs-1 mb-3">📅</div>
                    <h5>簡単作成</h5>
                    <p class="text-muted">
                        数分で予約ページを作成できます。
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="fs-1 mb-3">🔗</div>
                    <h5>URL共有</h5>
                    <p class="text-muted">
                        URLを送るだけで予約受付を開始できます。
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="fs-1 mb-3">👥</div>
                    <h5>予約管理</h5>
                    <p class="text-muted">
                        予約状況をリアルタイムで確認できます。
                    </p>
                </div>
            </div>
        </div>

    </div>

    <div class="mb-4">
        <h2 class="h4">予約ページを作成する</h2>
        <p class="text-muted">
            予約タイトルと日時を入力すると、参加者に共有できる予約ページが作成されます。
            説明欄には、レッスン内容・持ち物・注意事項などを自由に入力できます。
        </p>
    </div>

    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-4">

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
                          rows="3"
                          placeholder="レッスン内容や注意事項などを入力してください"></textarea>
            </div>

            <hr>

            <h5 class="mb-3">予約枠</h5>

            <div id="slot-container">

                <div class="slot-row mb-3 d-flex gap-2">

                    <input
                        type="datetime-local"
                        class="form-control slot-input">

                    <button
                        type="button"
                        class="btn btn-outline-danger remove-slot px-3 text-nowrap">
                        削除
                    </button>

                </div>

            </div>

            <div class="d-flex gap-2 flex-wrap mt-4">
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
    </div>

    <div class="mt-4" id="result"></div>

</main>

<footer class="bg-dark text-light py-4 mt-5">
    <div class="container text-center">
        <p class="mb-1">予約くん</p>
        <small>
            シンプルな予約ページ作成サービス
        </small>
        <p>
            <a href="https://github.com/s0323861/yoyakukun"
               class="btn btn-outline-light mt-3">
                GitHub
            </a>
        </p>
    </div>
</footer>

</body>
</html>
