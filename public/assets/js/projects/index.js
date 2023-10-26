let data_result;
let tblResult;
let re_init;

$(function () {
	$('#company').multiselect({
		buttonText: function (options, select) {
			return options.length + "名が選択されました";
		},
		buttonWidth: '100%',
		includeSelectAllOption: true,
		selectAllText: '全て選択',
		maxHeight: 400,
		enableFiltering: true,
	});

	$("#b_clear").click(function () {
		reset_form();
	});
});

// reset form
function reset_form() {
	$("#company option").each(function (e) {
		$("#company").multiselect('deselect', $(this).val());
	});

	$("#name").val('');
}
