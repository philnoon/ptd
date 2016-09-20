Handlebars.registerHelper('html_decoder', function(text) {
	var str = unescape(text).replace(/&amp;/g, '&');
	var div = document.createElement('div');
	div.innerHTML = str;
	return div.firstChild.nodeValue; 
});
