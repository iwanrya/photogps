// type 0 - Yes Only, 1 - Yes and No
function custom_alert(message, type, iserror, textYes, textNo, funcYes, funcNo, title, funcBefHide) {
    if (message === undefined) {
        message = "";
    }
    if (type === undefined) {
        type = 0;
    }
    if (iserror === undefined) {
        iserror = 1;
    }
    if (textYes === undefined) {
        textYes = "";
    }
    if (textNo === undefined) {
        textNo = "";
    }
    if (funcYes === undefined) {
        funcYes = null;
    }
    if (funcNo === undefined) {
        funcNo = null;
    }
    if (title === undefined) {
        title = "";
    }
    if (funcBefHide === undefined) {
        funcBefHide = null;
    }

    $('#popupBodyAlert').html(message);

    if (type == 0) {
        $('#pmca_yes').show();
        $('#pmca_no').hide();
    } else if (type == 1) {
        $('#pmca_yes').show();
        $('#pmca_no').show();
    }

    if (iserror == 0) {

    } else if (iserror == 1) {

    }

    if (textYes == "") {
        if (type == 0) {
            $('#pmca_yes').text("OK");
        } else {
            $('#pmca_yes').text("はい");
        }
    } else {
        $('#pmca_yes').text(textYes);
    }

    if (textNo == "") {
        $('#pmca_no').text("いいえ");
    } else {
        $('#pmca_no').text(textNo);
    }

    $('#pmca_header_alert').text(title);
    if (title != "") {
        $('#pmca_header').show();
    } else {
        $('#pmca_header').hide();
    }

    if (funcYes == null) {
        $('#pmca_yes').unbind("click").click(function () {
            $('#modal_custom_alert').modal('hide');
        });
    } else {
        $('#pmca_yes').unbind("click").click(function () {
            $('#modal_custom_alert').modal('hide');
            funcYes();
        });
    }

    if (funcNo == null) {
        $('#pmca_no').unbind("click").click(function () {
            $('#modal_custom_alert').modal('hide');
        });
    } else {
        $('#pmca_no').unbind("click").click(function () {
            $('#modal_custom_alert').modal('hide');
            funcNo();
        });
    }

    if (funcBefHide != null) {
        $(document).on('hide.bs.modal', '#modal_custom_alert', function (e) {
            funcBefHide();
        });
    }

    let timer = setInterval(function () {
        $('#modal_custom_alert').modal('show');

        clearInterval(timer);
    }, 500);
}