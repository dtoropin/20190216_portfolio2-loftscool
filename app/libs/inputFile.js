(function () {

	var input = $('.inputFile__input'),
		span = input.next(),
		spanVal = span.text();

	input.on('change', function (e) {
		var fileName = e.target.value.split( '\\' ).pop();
		if(fileName) span.text(fileName).css('color', '#727070')
			else span.text(spanVal).css('color', '#c7c6c6')
	});

})();