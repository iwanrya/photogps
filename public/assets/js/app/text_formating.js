if (!String.prototype.padStart) {
    String.prototype.padStart = function padStart(targetLength,padString) {
        targetLength = targetLength>>0; //truncate if number or convert non-number to 0;
        padString = String((typeof padString !== 'undefined' ? padString : ' '));
        if (this.length > targetLength) {
            return String(this);
        }
        else {
            targetLength = targetLength-this.length;
            if (targetLength > padString.length) {
                padString += padString.repeat(targetLength/padString.length); //append to original to ensure we are longer than needed
            }
            return padString.slice(0,targetLength) + String(this);
        }
    };
}

function price_format(x) {
	try {
		return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}
	catch(err) {
		if(x == undefined){
			return "0";
		}else{
			return x.toString();
		}
	}
}

function strip_price_format(x) {
	return x.toString().replace(/￥/g, "").replace(/,/g, "");
}

function lpad(words, length, text){

	words = (words + "");

    let x = '';
    for(y=0; y<length; y++){
        x += text;
    }

    return x.substring(0, length - words.length) + words;
}

function rpad(words, length, text){

	words = (words + "");

    let x = '';
    for(y=0; y<length; y++){
        x += text;
    }

    return words + x.substring(0, length - words.length);
}

function countCharLeft(maxLength, text){

	let newLines = (text.match(/(\r\n|\n|\r)/g) == null ? 0 : text.match(/(\r\n|\n|\r)/g).length);

	return maxLength - (text.length + newLines);
}

function conv_1b_to_2b(e) {
    let newText = "";
    for(i=0; i<e.length; i++){

    	if(e.charCodeAt(i) > 255){
			newText += e[i];
		}else{
			newText += String.fromCharCode(e.charCodeAt(i) + 65248);
		}
	}
    return newText;
};

function seperateSizeNumber(x){
	x = lpad(x, 4, "0");
	let sizeNumber = [0, 0, 0];
	
	sizeNumber[0] = parseInt(x.substr(0, 2));
	sizeNumber[1] = parseInt(x.substr(2, 1));
	sizeNumber[2] = parseInt(x.substr(3, 1));

	/*
	if(x / 10 > 1){
		sizeNumber[2] = parseInt(x.substr(-1, 1));
	}

	if(x / 10 > 1){
		sizeNumber[1] = parseInt(x.substr(-2, 1));
	}

	if(x / 1000 > 1){
		sizeNumber[0] = parseInt(x.substr(-4, 2));
	}else if(x / 100 > 1){
		sizeNumber[0] = parseInt(x.substr(-3, 1));
	}
	*/
	return sizeNumber;
}

function conv_jpn_to_cm(x){
	tempX = 0;

	if(x / 10 > 1){
		tempX += parseFloat(x.substr(-1, 1)) * 0.3;
	}

	if(x / 10 > 1){
		tempX += parseFloat(x.substr(-2, 1)) * 3.7;
	}

	if(x / 1000 > 1){
		tempX += parseFloat(x.substr(-4, 2)) * 37.8;
	}else if(x / 100 > 1){
		tempX += parseFloat(x.substr(-3, 1)) * 37.8;
	}

	return parseFloat(tempX).toFixed(1);
}

function to_yyyymmdd(japanDate) {
	return japanDate.substr(0, 4) + japanDate.substr(5, 2) + japanDate.substr(8, 2);
}

function to_yyyymmdd_jpn(date) {
	return date.substr(0, 4) + '年' + date.substr(4, 2) + '月' + date.substr(6, 2) + '日';
}

function to_yyyymm_jpn(date) {
	return date.substr(0, 4) + '年' + date.substr(4, 2) + '月';
}

function to_yyyymmdd_japan(date) {
	return date.getFullYear() + '年' + (date.getMonth() + 1) + '月' + date.getDate() + '日';
}

function to_yyyymm_japan(date) {
	return date.getFullYear() + '年' + (date.getMonth() + 1) + '月';
}

function get_spesific_date(year, month, p_date, cur_date){
	let date = new Date();
	
	let new_date = new Date();
	
	if(cur_date !== undefined){
		date = cur_date;
		new_date = cur_date;
	}
	
	if(year != 0){
		new_date.setYear(new_date.getFullYear() + year);
	
		if(new_date.getDate() < date.getDate()){
			new_date.setDate(0);
		}
	}
	if(month != 0){
		new_date.setMonth(new_date.getMonth() + month);
	
		if(new_date.getDate() < date.getDate()){
			new_date.setDate(0);
		}
	}
	if(p_date != 0){
		new_date.setDate(new_date.getDate() + p_date);
	}
	
	return new_date.getFullYear() + '/' + ('0' + (new_date.getMonth() + 1)).slice(-2) + '/' + ('0' + new_date.getDate()).slice(-2);
}

function get_spesific_date_as_date(year, month, p_date, cur_date){
	let date = new Date();
	
	let new_date = new Date();
	
	if(cur_date !== undefined){
		date = cur_date;
		new_date = cur_date;
	}
	
	if(year != 0){
		new_date.setYear(new_date.getFullYear() + year);
	
		if(new_date.getDate() < date.getDate()){
			new_date.setDate(0);
		}
	}
	if(month != 0){
		new_date.setMonth(new_date.getMonth() + month);
	
		if(new_date.getDate() < date.getDate()){
			new_date.setDate(0);
		}
	}
	if(p_date != 0){
		new_date.setDate(new_date.getDate() + p_date);
	}
	
	return new_date;
}

function get_today_date(){
	let date = new Date();
	return date.getFullYear() + '/' + ('0' + (date.getMonth() + 1)).slice(-2) + '/' + ('0' + date.getDate()).slice(-2);
}

function get_first_date_of_month(dt){
	let date = new Date(dt.getFullYear(), dt.getMonth()+1, 0);
	return date.getFullYear() + '/' + ('0' + (date.getMonth() + 1)).slice(-2) + '/01';
}

function get_last_date_of_month(dt){
	let date = new Date(dt.getFullYear(), dt.getMonth()+1, 0);
	return date.getFullYear() + '/' + ('0' + (date.getMonth() + 1)).slice(-2) + '/' + ('0' + date.getDate()).slice(-2);
}

function add_space_right_left(text, length){
	let new_text = text;
	for(k=0; k<(length-text.length)/2; k++){
		new_text = " " + new_text + " ";
	}
	return new_text;
}

function check_valid_birthdate(date){
	if(parseInt(date.substr(0, 4)) > 0 && parseInt(date.substr(4,2)) && parseInt(date.substr(6,2)) ){
		return true;
	}
	else{
		return false;
	}
}

function calculateAge(birthday) { // birthday is a date
    let ageDifMs = Date.now() - birthday.getTime();
    let ageDate = new Date(ageDifMs); // miliseconds from epoch
    return Math.abs(ageDate.getUTCFullYear() - 1970);
}

function postalFormat(postal){
	if(postal != "" && postal.length > 3){
		return postal.substr(0,3) + "-" + postal.substring(3);
	}else{
		return postal;
	}
}

function phoneFormat(){
	
	if(event.keyCode >= 48 && event.keyCode <= 57 || event.keyCode == 45){
		
	}else{
		event.preventDefault();
	}
}

function zipcode_focus(text){
	let x = $(text).val();
	$(text).val(x.replace("-", ""));
}

function zipcode_blur(text){
	$(text).val(postalFormat($(text).val()));
}

function numbericFormat(){
	if(event.keyCode >= 48 && event.keyCode <= 57){
		
	}else{
		event.preventDefault();
	}
}

function decimalFormat(){
	if((event.keyCode >= 48 && event.keyCode <= 57) || event.keyCode == 190){
		
	}else{
		event.preventDefault();
	}
}

function unicode_only(text){
	if(findMultibyte($(text).val())){
		$(text).val("");
	}
}

function findMultibyte(str) {
	let x_found = false;
	let x_cnt = 0;
	while(!x_found && x_cnt < str.length){
		if(str.charCodeAt(x_cnt) > 195){
			x_found = true;
		}
		x_cnt++;
	}
    return x_found;
}

(function() {
	/**
	* Decimal adjustment of a number.
	*
	* @param {String}  type  The type of adjustment.
	* @param {Number}  value The number.
	* @param {Integer} exp   The exponent (the 10 logarithm of the adjustment base).
	* @returns {Number} The adjusted value.
	*/
	function decimalAdjust(type, value, exp) {
		// If the exp is undefined or zero...
		if (typeof exp === 'undefined' || +exp === 0) {
			return Math[type](value);
		}
		value = +value;
		exp = +exp;
		// If the value is not a number or the exp is not an integer...
		if (isNaN(value) || !(typeof exp === 'number' && exp % 1 === 0)) {
			return NaN;
		}
		// Shift
		value = value.toString().split('e');
		value = Math[type](+(value[0] + 'e' + (value[1] ? (+value[1] - exp) : -exp)));
		// Shift back
		value = value.toString().split('e');
		return +(value[0] + 'e' + (value[1] ? (+value[1] + exp) : exp));
	}

	// Decimal round
	if (!Math.round10) {
		Math.round10 = function(value, exp) {
			return decimalAdjust('round', value, exp);
		};
	}
	// Decimal floor
	if (!Math.floor10) {
		Math.floor10 = function(value, exp) {
			return decimalAdjust('floor', value, exp);
		};
	}
	// Decimal ceil
	if (!Math.ceil10) {
		Math.ceil10 = function(value, exp) {
			return decimalAdjust('ceil', value, exp);
		};
	}
})();

function valid_date_on_month(month, date){
	let x = [31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
	
	if(date > x[month-1]){
		return false;
	}else{
		return true;
	}
}

function monthDiff(dateFrom, dateTo) {
	return dateTo.getMonth() - dateFrom.getMonth() + (12 * (dateTo.getFullYear() - dateFrom.getFullYear()));
}

function file_size_in_text(size){
	if (isNaN(size)) {
		return size;
	} else if (size >= 1000000) {
		return (parseFloat(size/ 1000000,2)).toFixed(2) + "MB";
	} else {
		return (parseFloat(size/ 1000,2)).toFixed(2) + "KB";
	}
}

function parse_obj_to_querystring(data) { 
    let s = ""; 
    for (let key in data) { 
        if (s != "") { 
            s += "&"; 
        } 
        s += (key + "=" + encodeURIComponent(data[key])); 
    } 
    
    return s;
} 