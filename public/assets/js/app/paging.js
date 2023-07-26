$(document).on('change', '#tblResult thead th input[data-expt]', function () {
    if ($(this).is(":checked")) {
        $("#tblResult tbody td input[data-expt]:visible").prop('checked', $(this).is(":checked"));
    } else {
        $("#tblResult tbody td input[data-expt]").prop('checked', $(this).is(":checked"));
    }
});

function datatable_page_change(table) {
    replaceURLParam('page', table.page.info().page + 1);
    replaceURLParam("rp", table.page.info().length);
}