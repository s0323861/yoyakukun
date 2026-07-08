$(function () {

    function checkInput() {

        const title = $("#title").val();

        let hasSlot = false;

        $(".slot-input").each(function() {
            if ($(this).val() !== "") {
                hasSlot = true;
            }
        });

        if (title.length > 0 && hasSlot) {
            $("#createBtn").prop("disabled", false);
        }
        else {
            $("#createBtn").prop("disabled", true);
        }
    }

    $("#title").on(
        "keyup change input",
        checkInput
    );

    $(document).on(
        "change input",
        ".slot-input",
        checkInput
    );

    let slotCount = 1;

    $("#add-slot").click(function() {

        slotCount++;

        $("#slot-container").append(`
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
        `);

        checkInput();

    });

    $(document).on(
        "click",
        ".remove-slot",
        function() {

            if ($(".slot-row").length <= 1) {
                alert("予約枠は1つ以上必要です。");
                return;
            }

            $(this)
                .closest(".slot-row")
                .remove();

            checkInput();

        }
    );

    $("#createBtn").click(function () {

        let slots = [];

        $(".slot-input").each(function() {

            if ($(this).val() !== "") {
                slots.push($(this).val());
            }

        });

        $.ajax({

            type: "POST",

            url: "create.php",

            dataType: "json",

            data: {

                title: $("#title").val(),

                description: $("#description").val(),

                slots: slots

            }

        })

        .done(function(response) {

            $("#result").html(`

                <div class="row mt-4">

                    <div class="col-md-6 mb-3">

                        <div class="card border-success shadow-sm h-100">

                            <div class="card-header bg-success text-white">
                                参加者向けURL
                            </div>

                            <div class="card-body">

                                <input
                                    class="form-control mb-3"
                                    value="${response.url}"
                                    readonly>

                                <a href="${response.url}"
                                target="_blank"
                                class="btn btn-success w-100">

                                    予約ページを開く

                                </a>

                            </div>

                        </div>

                    </div>

                    <div class="col-md-6 mb-3">

                        <div class="card border-primary shadow-sm h-100">

                            <div class="card-header bg-primary text-white">
                                管理者向けURL
                            </div>

                            <div class="card-body">

                                <p class="text-muted small">
                                    このURLは予約状況の確認に使用します。<br>
                                    参加者には共有しないでください。
                                </p>

                                <input
                                    class="form-control mb-3"
                                    value="${response.admin_url}"
                                    readonly>

                                <a href="${response.admin_url}"
                                target="_blank"
                                class="btn btn-primary w-100">

                                    管理画面を開く

                                </a>

                            </div>

                        </div>

                    </div>

                </div>

            `);

        })

        .fail(function() {

            $("#result").html(

                `
                <div class="alert alert-danger">
                    エラーが発生しました。
                </div>
                `
            );

        });

    });

});