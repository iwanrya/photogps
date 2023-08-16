$(document).ready(function () {

    if ($('#tblResult').length > 0) {

        tblResult = $('#tblResult').DataTable({
            "dom": "Brltp",
            "buttons": [],
            "columns": [
                {
                    render: (data, type, row) =>
                        data[0] + '<br><input value="' + data[1].id + '" class="select-checkbox" type="checkbox">',
                    className: 'dt-body-center'
                },
                { className: "text-left" },
                { className: "text-center align-middle" },
            ],
            "ordering": false,
            "oLanguage": {
                "sLengthMenu": "_MENU_ <span class='ms-2'>件表示</span><span class='ms-2'><span id='hit_count' class='text-danger'>0件</span><span class='ml-10'>のデータが該当しました。</span></span>",
            },
            "language": {
                "emptyTable": "検索に該当するデータがありません",
                "paginate": {
                    "previous": "前へ",
                    "next": "次へ",
                }
            },
            "lengthMenu": [50, 150, 300],
            "pageLength": re_init !== undefined ? parseInt(re_init.rp) : 300,
            drawCallback: function () {
                $('.paginate_button:not(.disabled)', this.api().table().container())
                    .on('click', function () {
                        datatable_page_change();
                    });
                $('[name="tblResult_length"]', this.api().table().container())
                    .on('click', function () {
                        datatable_page_change();
                    });
            },
            scrollY: 500,
            scrollCollapse: true,
        });

        tblResult.on('change', 'input.select-checkbox', function (e) {
            console.log(e.currentTarget.value);
        });
    }

});

function populate_search_data(data) {
    tblResult.clear();

    $("#hit_count").html(price_format(data.length) + '件');

    if (data.length > 0) {
        for (i = 0; i < data.length; i++) {

            c_data = data[i];

            let dv_info =
                "<div class='row mb-20'>" +
                "<div class='col-4'>" +
                "<strong>撮影者</strong>" +
                "</div>" +
                "<div class='col-8'>" +
                c_data.photographer +
                "</div>" +
                "</div>" +

                "<div class='row mb-20'>" +
                "<div class='col-4'>" +
                "<strong>撮影日時</strong>" +
                "</div>" +
                "<div class='col-8'>" +
                (c_data.post_photo.length > 0 ? c_data.post_photo[0].shoot_datetime_formatted : "") +
                "</div>" +
                "</div>" +

                "<div class='row'>" +
                "<div class='col-4'>" +
                "<strong>撮影場所 / GPS情報</strong>" +
                "</div>" +
                "<div class='col-8'>" +
                "<strong>緯度</strong>: " + (c_data.post_photo.length > 0 ? c_data.post_photo[0].latitude : "-") + " <strong>経度</strong>: " + (c_data.post_photo.length > 0 ? c_data.post_photo[0].longitude : "") +
                "</div>" +
                "</div>" +

                "<div class='row'>" +
                "<div class='col-12 text-right'>" +
                "<button data-bs-toggle='modal' data-id='" + c_data.id + "' data-bs-target='#popup_photo_mobile_detail' class='btn btn-primary'>詳細</button>" +
                "</div>" +
                "</div>";

            let photo = "<img src='" + (c_data.post_photo.length > 0 ? c_data.post_photo[0].thumbnail : "") + "' style='max-width: 120px; max-heigth: 120px;'/>";

            tblResult.row.add([
                [i + 1, c_data],
                dv_info,
                photo
            ]);
        }
    }

    tblResult.draw();

    if (re_init !== undefined) {
        tblResult.page(parseInt(re_init.page) - 1).draw('page');
        re_init = undefined;
    }
}

function check_filter_condition_is_default() {

    if ($("#photographer").val() !== "") {
        return false;
    }

    if ($("[data-date-start=1]").val() !== "" || $("[data-date-end=1]").val() !== "") {
        return false;
    }

    if ($("#comment").val() !== "") {
        return false;
    }

    return true;
}