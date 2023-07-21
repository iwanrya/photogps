$(function () {

    $.fn.datepicker.defaults.format = "yyyy/mm/dd";

    $(".datepicker").datepicker({
        autoclose: true,
        todayHighlight: true,
        language: 'ja',
        orientation: "bottom"
    });

    $(".datepicker").attr("autocomplete", "off");

    $(".timepicker").timepicker({
        'disableTextInput': true,
        'timeFormat': 'H:i',
        'forceRoundTime': true,
        'step': 10
    });

    $(document).on('click', '#btnGoToTop', function () {
        //window.scrollTo(0, 0);
        $("html, body").animate({ scrollTop: 0 }, "fast");
    });

    $('.modal').on("hidden.bs.modal", function (e) {
        if ($('.modal:visible').length) {
            $('body').addClass('modal-open');
        }
    });

});