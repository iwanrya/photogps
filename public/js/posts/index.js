$(function () {
    $('#photographer').multiselect({
        buttonText: function (options, select) {
            return options.length + "名が選択されました";
        },
        buttonWidth: '100%',
        includeSelectAllOption: true,
        selectAllText: '全て選択',
        maxHeight: 400,
        enableFiltering: true,
    });

    if (getQueryString('ex') == '1') {
		re_init = {};
		re_init.rp = getQueryString('rp');
		re_init.page = getQueryString('page');
	}

	$(document).on('click', '[data-btn-date]', function () {
		if ($(this).hasClass("btn-success") === false) {
			$("[data-btn-date=" + $(this).attr('data-btn-date') + "]").each(function () {
				if ($(this).hasClass("btn-success")) {
					$(this).removeClass("btn-success");
				}
				if ($(this).hasClass("btn-default") === false) {
					$(this).addClass("btn-default");
				}
			});

			$(this).removeClass("btn-default");
			$(this).addClass("btn-success");

			$("[data-date-start=" + $(this).attr('data-btn-date') + "]").prop('disabled', true);
			$("[data-date-end=" + $(this).attr('data-btn-date') + "]").prop('disabled', true);

			var x_date = 0;
			if ($(this).attr('data-val') == '1') {
				x_date = 0;
			} else if ($(this).attr('data-val') == '2') {
				x_date = -7;
			} else if ($(this).attr('data-val') == '3') {
				x_date = -30;
			} else if ($(this).attr('data-val') == '4') {
				x_date = -90;
			}

			$("[data-date-start=" + $(this).attr('data-btn-date') + "]").datepicker('setDate', get_spesific_date_as_date(0, 0, x_date));
			$("[data-date-end=" + $(this).attr('data-btn-date') + "]").datepicker('setDate', get_spesific_date_as_date(0, 0, 0));

		} else {
			$(this).removeClass("btn-success");
			$(this).addClass("btn-default");

			$("[data-date-start=" + $(this).attr('data-btn-date') + "]").prop('disabled', false);
			$("[data-date-end=" + $(this).attr('data-btn-date') + "]").prop('disabled', false);

			$("[data-date-start=" + $(this).attr('data-btn-date') + "]").datepicker('setDate', '');
			$("[data-date-end=" + $(this).attr('data-btn-date') + "]").datepicker('setDate', '');
		}

	});

	$("#b_clear").click(function () {
		reset_form();
	});

	// button search
	$("#b_search").click(function () {
		if (validate_form()) {

			if (check_filter_condition_is_default()) {
				custom_alert('全件を検索しますが、よろしいですか。', 1, 0, '', '', execute_search, null, '確認');
			} else {
				execute_search();
			}

		}
	});

	if (getQueryString('ex') == '1') {
		execute_search();
	}
});