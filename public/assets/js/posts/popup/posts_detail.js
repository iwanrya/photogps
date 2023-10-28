var sel_photo_mobile_id = "";
var ppmd_data = null;

$(document).ready(function () {

});

$(document).on('show.bs.modal', '#popup_photo_mobile_detail', function (e) {
	ppmd_data = null;
	sel_photo_mobile_id = $(e.relatedTarget).data('id');

	ppmdLoadDetail(sel_photo_mobile_id);
	ppmdLoadComment(sel_photo_mobile_id);
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

$(document).on('click', '#ppmd_report', function () {

});

$(document).on('click', '#ppmd_add_comment', function () {
	var comment = $('#ppmd_new_comment').val();
	if (comment.trim()) {
		ppmdAddComment(sel_photo_mobile_id, comment);
	}
});

function ppmdLoadDetail(id) {
	loading_start();
	$.ajax
		({
			type: "GET",
			url: url_photo_mobile_read_one,
			data: {
				photo_mobile_id: id,
			},
			success: function (data) {
				ppmd_data = data.data
				ppmdDrawDetail();
			},
			error: function (XMLHttpRequest, textStatus, errorThrown) {
				custom_alert("Status: " + textStatus);
				custom_alert("Error: " + errorThrown);
			}
		}).always(function () {
			loading_end();
		});
}

function ppmdLoadComment(id) {
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
					ppmdDrawComment(data.data);
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

function ppmdDrawDetail() {
	let item = ppmd_data;

	$("#ppmd_image_original").attr('href', item.zip_photo_original);
	$("#ppmd_image_no_exif").attr('href', item.zip_photo);
	$("#ppmd_report").attr('href', item.report);

	// // maps
	// if (item.post_photo[0].latitude === 0.0 && item.post_photo[0].longitude === 0.0) {
	// 	$("#ppmd_maps").addClass("d-none");
	// 	$("#ppmd_no_gps_info").removeClass("d-none");
	// } else {
	// 	$("#ppmd_maps").removeClass("d-none");
	// 	$("#ppmd_no_gps_info").addClass("d-none");
	// 	$("#ppmd_maps").html("<iframe id=\"ppmd_maps_fix\" width=\"100%\" min-height=\"150\" frameborder=\"0\" scrolling=\"no\" marginheight=\"0\" marginwidth=\"0\"" +
	// 		"src=\"https://www.openstreetmap.org/export/embed.html?bbox=" + (item.post_photo[0].longitude - 0.002) + "," + (item.post_photo[0].latitude - 0.002) + "," + (item.post_photo[0].longitude + 0.002) + "," + (item.post_photo[0].latitude + 0.002) + "&layer=mapnik&marker=" + item.post_photo[0].latitude + "," + item.post_photo[0].longitude + "\" style=\"border: 1px solid black\">" +
	// 		"</iframe>" +
	// 		"<br />" +
	// 		"<small><a target=\"_blank\" href=\"" + base_url + "maps?lat=" + item.post_photo[0].latitude + "&long=" + item.post_photo[0].longitude + "\">地図を拡大</a></small>");

	// }

	// thumbnail
	// $("#ppmd_image").html("<a target=\"_blank\" href=\"" + item.photo + "\"><img src=\"" + item.thumbnail + "\"/></a>");

	$("#ppmd_image").empty();
	let ppmd_image = "";
	item.post_photo.forEach((value, index, arr) => {
		// ppmd_image += "<div style=\"cursor: pointer; width: 70px; height: 70px;\">" +
		// 	"<img data-image=\"" + value.id + "\" src=\"" + value.thumbnail + "\" onclick=\"ppmdOpenImage('" + value.photo + "', '" + value.longitude + "', '" + value.latitude + "')\" style=\"max-width: 100%; max-height: 100%;\"/>" +
		// 	"</div>";
		ppmd_image += "<div style=\"cursor: pointer; width: 70px; height: 70px;\">" +
			"<img src=\"" + value.thumbnail + "\" onclick=\"ppmdOpenImage(" + value.id + ")\" style=\"max-width: 100%; max-height: 100%;\"/>" +
			"</div>";
	});
	$("#ppmd_image").html("<div class=\"col-12\" style=\"overflow-x: auto; background-color: rgb(245, 245, 245); display: -webkit-box;\">" + ppmd_image + "</div>");
}

function ppmdOpenImage(image_id) {
	let item = null;
	ppmd_data.post_photo.forEach((value, index, arr) => {
		if (value.id == image_id) {
			item = value;
		}
	});

	if (item != null) {
		ppmiiLoad(item);
	}
}

// function ppmdOpenImage(photo_url, longitude, latitude) {

// 	longitude = parseFloat(longitude);
// 	latitude = parseFloat(latitude);

// 	let image = "<img src=\"" + photo_url + "\" style=\"max-width: 100%; max-height: 300px\"/>"

// 	let maps = "";

// 	maps = "<iframe width=\"100%\" height=\"300\" frameborder=\"0\" scrolling=\"no\" marginheight=\"0\" marginwidth=\"0\"" +
// 		"src=\"https://www.openstreetmap.org/export/embed.html?bbox=" + (longitude - 0.002) + "," + (latitude - 0.002) + "," + (longitude + 0.002) + "," + (latitude + 0.002) + "&layer=mapnik&marker=" + latitude + "," + longitude + "\" style=\"border: 1px solid black\">" +
// 		"</iframe>" +
// 		"<br />" +
// 		"<small><a target=\"_blank\" href=\"" + base_url + "maps?lat=" + latitude + "&long=" + longitude + "\">地図を拡大</a></small>";

// 	let body_alert = "<div style=\"background-color: rgb(245, 245, 245); text-align: center;\">" + image + "</div>"
// 		+ "<div class=\"mt-3\">" + maps + "</div>";

// 	custom_alert(body_alert, 0, 0, "閉じる");
// }

function ppmdDrawComment(item) {

	// draw table
	$("#dv_ppmd_comment").empty();

	if (item.length > 0) {
		item = item.reverse();
		item.forEach(e => {
			ppmdAppendComment(e);
		});
	}
}

function ppmdAppendComment(item) {
	var html = "<div class=\"row\">" +
		"	<div class=\"col-8\" style=\"font-size: 10px\">(" + item.create_user.name + ") <span><strong>" + item.create_user.username + "</strong></span></div>" +
		"	<div class=\"col-4 text-right\" style=\"font-size: 10px\"><strong>" + item.created_at_formatted + "</strong></div>" +
		"</div>" +
		"<p class=\"bordered-box\" style=\"white-space: break-spaces;\">" +
		item.comment +
		"</p>"
	$("#dv_ppmd_comment").append(html);
}

function ppmdAddComment(id, comment) {
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
					ppmdResetComment();
					ppmdLoadComment(id);
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

function ppmdResetComment() {
	$("#ppmd_new_comment").val('');
}