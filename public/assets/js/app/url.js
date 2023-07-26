function getQueryString(sParam) {
    let sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i,
        sResult = [];

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        // parameter name end with [] = array
        if (sParameterName[0] === sParam && /\[]$/.test(sParameterName[0])) {
            sResult.push(decodeURIComponent(sParameterName[1]));
        } else if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }

    if (sResult.length > 0) {
        return sResult;
    }
    return null;
};

function getURLParam(index, removeKres) {

	if (removeKres === undefined) {
		removeKres = 0;
	}

	params = window.location.href.replace(base_url, "").split("/");

	if (params.length - 1 >= index) {
		if (removeKres == 1) {
			return params[index].substr(0, params[index].indexOf("#"));
		} else {
			return params[index];
		}
	} else {
		return null;
	}
}

function getURLParamExternal(url_ref, index, removeKres) {

	if (removeKres === undefined) {
		removeKres = 0;
	}

	if (url_ref.indexOf(base_url) !== false) {

		params = url_ref.replace(base_url, "").split("/");

		if (params.length - 1 >= index) {
			if (removeKres == 1) {
				return params[index].substr(0, params[index].indexOf("#"));
			} else {
				return params[index];
			}
		}
	}

	return null;
}

function replaceURLParam(key, value) {
	let cur_value = getQueryString(key);
	if (location.href.indexOf(key + '=') > -1) {
		history.pushState({}, document.getElementsByTagName("title")[0].innerHTML, location.href.replace(key + '=' + cur_value, key + '=' + value));

		// If not, append
	} else {
		history.pushState({}, document.getElementsByTagName("title")[0].innerHTML, location.href + (location.href.indexOf('?') > -1 ? '&' : '?') + key + '=' + value);
	}
}

$.urlParam = function (name) {
	let results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
	if (results == null) {
		return null;
	}
	return decodeURI(results[1]) || 0;
};