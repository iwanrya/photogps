let x_cnt_ld = 0;

function loading_start() {
    if (x_cnt_ld == 0) {
        $("#div_loading_page").css('display', 'table');
    }
    x_cnt_ld++;
}

function loading_end() {
    x_cnt_ld--;
    if (x_cnt_ld == 0) {
        $("#div_loading_page").hide();
    }
}