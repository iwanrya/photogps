function ppmiiLoad(item) {
	ppmiiDraw(item);
	$('#popup_photo_mobile_image_info').modal('show');
}

function ppmiiDraw(item) {

	$("#ppmii_image_original").attr('href', item.photo_original);
	$("#ppmii_image_no_exif").attr('href', item.photo);

	// gps location
	$("#ppmii_latitude").html(item.latitude);
	$("#ppmii_longitude").html(item.longitude);

	// maps
	if (item.latitude === 0.0 && item.longitude === 0.0) {
		$("#ppmii_maps").addClass("d-none");
		$("#ppmii_no_gps_info").removeClass("d-none");
	} else {
		$("#ppmii_maps").removeClass("d-none");
		$("#ppmii_no_gps_info").addClass("d-none");
		$("#ppmii_maps").html("<iframe width=\"100%\" min-height=\"150\" frameborder=\"0\" scrolling=\"no\" marginheight=\"0\" marginwidth=\"0\"" +
			"src=\"https://www.openstreetmap.org/export/embed.html?bbox=" + (item.longitude - 0.002) + "," + (item.latitude - 0.002) + "," + (item.longitude + 0.002) + "," + (item.latitude + 0.002) + "&layer=mapnik&marker=" + item.latitude + "," + item.longitude + "\" style=\"border: 1px solid black\">" +
			"</iframe>" +
			"<br />" +
			"<small><a target=\"_blank\" href=\"" + base_url + "maps?lat=" + item.latitude + "&long=" + item.longitude + "\">地図を拡大</a></small>");

	}

	// image
	$("#ppmii_image").empty();
	$("#ppmii_image").html("<img src=\"" + item.custom_size + "/500\" style=\"max-width: 100%; max-height: 500px\"/>");
}