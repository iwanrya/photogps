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

			let x_date = 0;
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

// reset form
function reset_form() {
	$("#hit_count").html('0件');

	$("#photographer option").each(function (element) {
		$("#photographer").multiselect('deselect', $(this).val());
	});

	$("#shoot_date_start").datepicker('setDate', '');
	$("#shoot_date_start").prop('disabled', false);

	$("#shoot_date_end").datepicker('setDate', '');
	$("#shoot_date_end").prop('disabled', false);

	$("[data-btn-date]").each(function () {
		if ($(this).hasClass("btn-success")) {
			$(this).removeClass("btn-success");
		}
		if ($(this).hasClass("btn-default") === false) {
			$(this).addClass("btn-default");
		}
	});

	$("#comment").val('');

	tblResult.clear().draw();
}

// button execute / filter
function execute_search() {

	let photographer = [];
	$('#photographer option:selected').each(function () {
		photographer.push($(this).val());
	});

	let obj = {
		photographer: photographer,
		shoot_date_start: $("#shoot_date_start").val(),
		shoot_date_end: $("#shoot_date_end").val(),
		comment: $("#comment").val(),
	};
	str_query = "?" + parse_obj_to_querystring(obj);

	loading_start();

	$.ajax
		({
			type: "GET",
			url: url_photo_mobile_read,
			data: {
				photographer: photographer,
				shoot_date_start: $("#shoot_date_start").val(),
				shoot_date_end: $("#shoot_date_end").val(),
				comment: $("#comment").val(),
			},
			success: function (data) {
				data_result = data.data;
				populate_search_data(data.data)
			},
			error: function (XMLHttpRequest, textStatus, errorThrown) {
				custom_alert("Status: " + textStatus);
				custom_alert("Error: " + errorThrown);
			}
		}).always(function () {
			history.pushState({}, document.getElementsByTagName("title")[0].innerHTML, current_page + get_filter());
			replaceURLParam("ex", "1");
			datatable_page_change(tblResult);
			loading_end();

		});
}

function validate_form() {
	return true;
}

function get_filter() {
	let str_query = "?";

	$('#photographer option:selected').each(function () {
		str_query += "photographer[]=" + $(this).val() + "&";
	});

	if ($("#shoot_date_start").val() !== "") {
		str_query += "shoot_date_start=" + $("#shoot_date_start").val() + "&";
	}

	if ($("#shoot_date_end").val() !== "") {
		str_query += "shoot_date_end=" + $("#shoot_date_end").val() + "&";
	}

	if ($("#comment").val() !== "") {
		str_query += "comment=" + $("#comment").val() + "&";
	}

	return str_query == "?" ? "" : str_query;
}