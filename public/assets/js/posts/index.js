let data_result;
let tblResult;
let re_init;

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

	if (getQueryString('filter_date_toogle_1') != null) {
		$("#shoot_date_start").prop('readonly', true);
		$("#shoot_date_end").prop('readonly', true);
	}

	$(document).on('change', '[data-btn-date]', function (v) {
		if ($(v.target).prop('checked')) {
			$("[data-btn-date=" + $(this).attr('data-btn-date') + "]").each(function (index, e) {
				if ($(e).val() != v.target.value) {
					$(e).prop('checked', false);
				}
			});

			$("[data-date-start=" + $(this).attr('data-btn-date') + "]").prop('readonly', true);
			$("[data-date-end=" + $(this).attr('data-btn-date') + "]").prop('readonly', true);

			let x_date = 0;
			if (v.target.value == '1') {
				x_date = 0;
			} else if (v.target.value == '2') {
				x_date = -7;
			} else if (v.target.value == '3') {
				x_date = -30;
			} else if (v.target.value == '4') {
				x_date = -90;
			}

			$("[data-date-start=" + $(this).attr('data-btn-date') + "]").datepicker('setDate', get_spesific_date_as_date(0, 0, x_date));
			$("[data-date-end=" + $(this).attr('data-btn-date') + "]").datepicker('setDate', get_spesific_date_as_date(0, 0, 0));

		} else {
			$("[data-date-start=" + $(this).attr('data-btn-date') + "]").prop('readonly', false);
			$("[data-date-end=" + $(this).attr('data-btn-date') + "]").prop('readonly', false);

			$("[data-date-start=" + $(this).attr('data-btn-date') + "]").datepicker('setDate', '');
			$("[data-date-end=" + $(this).attr('data-btn-date') + "]").datepicker('setDate', '');
		}

	});

	$("#b_clear").click(function () {
		reset_form();
	});
});

// reset form
function reset_form() {
	$("#photographer option").each(function (e) {
		$("#photographer").multiselect('deselect', $(this).val());
	});

	$("#shoot_date_start").datepicker('setDate', '');
	$("#shoot_date_start").prop('readonly', false);

	$("#shoot_date_end").datepicker('setDate', '');
	$("#shoot_date_end").prop('readonly', false);

	$("[data-btn-date]").each(function () {
		$(this).prop('checked', false);
	});

	$("#comment").val('');
}
