var sel_photo_mobile_id = "";

$(document).ready(function () {

});

$(document).on('show.bs.modal', '#popup_photo_mobile_detail', function (e) {
	sel_photo_mobile_id = $(e.relatedTarget).data('id');

	pmdLoadDetail(sel_photo_mobile_id);
	pmdLoadComment(sel_photo_mobile_id);
});

$(document).on('click', '#ppmd_delete:enabled', function () {

	var funcYes = function () {

		loading_start();

		var formData = new FormData();
		formData.append("photo_mobile_id", sel_photo_mobile_id);

		$.ajax({
			url: url_photo_mobile_delete,
			type: "POST",
			data: formData,
			cache: false,
			contentType: false,
			processData: false,
			success: function (res) {
				if (res.status) {
					var funcBefHide = function () {
						loading_start();
						location.reload();
					}

					custom_alert(res.message, 0, 0, "OK", "", null, null, "", funcBefHide);
				}
				else {
					if (res.error_code) {
						custom_alert(res.error_code);
					} else {
						custom_alert("");
					}
				}
			},
			error: function () {
				custom_alert("サーバ接続エラー");
			}
		}).always(function () {
			loading_end();
		});
	};
	custom_alert('データを削除してもよろしいですか。', 1, 0, "", "", funcYes, null, "確認");

});

$(document).on('click', '#ppmd_add_comment', function () {
	var comment = $('#pmd_new_comment').val();
	if (comment.trim()) {
		pmdAddComment(sel_photo_mobile_id, comment);
	}
});

function pmdLoadDetail(id) {
	loading_start();
	$.ajax
		({
			type: "GET",
			url: url_photo_mobile_read_one,
			data: {
				photo_mobile_id: id,
			},
			success: function (data) {
				pmdDrawDetail(data.data);
			},
			error: function (XMLHttpRequest, textStatus, errorThrown) {
				custom_alert("Status: " + textStatus);
				custom_alert("Error: " + errorThrown);
			}
		}).always(function () {
			loading_end();
		});
}

function pmdLoadComment(id) {
	loading_start();
	$.ajax
		({
			type: "GET",
			url: url_photo_mobile_comment_read,
			data: {
				photo_mobile_id: id,
			},
			success: function (data) {
				if (data.status) {
					pmdDrawComment(data.data);
				}
			},
			error: function (XMLHttpRequest, textStatus, errorThrown) {
				custom_alert("Status: " + textStatus);
				custom_alert("Error: " + errorThrown);
			}
		}).always(function () {
			loading_end();
		});
}

function pmdDrawDetail(item) {

	$("#pmd_image_original").attr('href', item.photo_original);
	$("#pmd_image_no_exif").attr('href', item.photo);

	// maps
	if (item.latitude === 0.0 && item.longitude === 0.0) {
		$("#pmd_maps").html("<div class=\"no-gps-info\">位置情報が特定できないため、地図が表示できません</div>");
	} else {
		$("#pmd_maps").html("<iframe width=\"100%\" min-height=\"150\" frameborder=\"0\" scrolling=\"no\" marginheight=\"0\" marginwidth=\"0\"" +
			"src=\"https://www.openstreetmap.org/export/embed.html?bbox=" + (item.longitude - 0.002) + "," + (item.latitude - 0.002) + "," + (item.longitude + 0.002) + "," + (item.latitude + 0.002) + "&layer=mapnik&marker=" + item.latitude + "," + item.longitude + "\" style=\"border: 1px solid black\">" +
			"</iframe>" +
			"<br />" +
			"<small><a target=\"_blank\" href=\"" + base_url + "maps?lat=" + item.latitude + "&long=" + item.longitude + "\">地図を拡大</a></small>");
	}

	// thumbnail
	// $("#pmd_image").html("<a target=\"_blank\" href=\"" + item.photo + "\"><img src=\"" + item.thumbnail + "\"/></a>");
	$("#pmd_image").html("<span style=\"cursor: pointer;\" onclick=\"pmdOpenImage('" + item.photo + "')\"><img src=\"" + item.thumbnail + "\" /></span>");
}

function pmdOpenImage(photo_url) {
	custom_alert("<img src=\"" + photo_url + "\" style=\"max-width: 100%\"/>", 0, 0, "閉じる");
}

function pmdDrawComment(item) {

	// draw table
	$("#dv_pmd_comment").empty();

	if (item.length > 0) {
		item = item.reverse();
		item.forEach(e => {
			pmdAppendComment(e);
		});
	}
}

function pmdAppendComment(item) {
	var html = "<div class=\"row\">" +
		"	<div class=\"col-8\" style=\"font-size: 10px\">(" + item.user.name + ") <span><strong>" + item.user.username + "</strong></span></div>" +
		"	<div class=\"col-4 text-right\" style=\"font-size: 10px\"><strong>" + item.created_at_formatted + "</strong></div>" +
		"</div>" +
		"<p class=\"bordered-box\" style=\"white-space: break-spaces;\">" +
		item.comment +
		"</p>"
	$("#dv_pmd_comment").append(html);
}

function pmdAddComment(id, comment) {
	loading_start();
	$.ajax
		({
			type: "POST",
			url: url_photo_mobile_comment_insert,
			data: {
				photo_mobile_id: id,
				comment: comment
			},
			success: function (res) {
				if (res.status) {
					pmdResetComment();
					pmdLoadComment(id);
				}
			},
			error: function (XMLHttpRequest, textStatus, errorThrown) {
				custom_alert("Status: " + textStatus);
				custom_alert("Error: " + errorThrown);
			}
		}).always(function () {
			loading_end();
		});
}

function pmdResetComment() {
	$("#pmd_new_comment").val('');
}