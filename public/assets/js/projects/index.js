let data_result;
let tblResult;
let re_init;

$(function () {

});

$('#company').multiselect({
	buttonText: function (options, select) {
		return options.length + "件が選択されました";
	},
	buttonWidth: '100%',
	includeSelectAllOption: true,
	selectAllText: '全て選択',
	maxHeight: 400,
	enableFiltering: true,
});

$(document).on('click', '#b_clear', function () {
	reset_form();
});

// reset form
function reset_form() {
	$("#company option").each(function (e) {
		$("#company").multiselect('deselect', $(this).val());
	});

	$("#name").val('');
}
