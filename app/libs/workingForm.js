// workingForm (ajax, validate)
var workingForm = (function () {

	var validate = function (form) {
		var elems = $(form).find('input, textarea').not('input[type="hidden"]'),
			valid = true;

		$.each(elems, function (i, val) {
			var pos = val.hasAttribute('tip-position')
				? val.getAttribute('tip-position')
				: 'left';
			
			if (val.value.length === 0) {
				val.classList.add('error');
				valid = false;
			}
		});
		return valid;
	};

	var ajax = function (url, data) {
		return $.ajax({
			url: url,
			type: 'POST',
			dataType: 'json',
			cache: false,
			contentType: false,
			processData: false,
			data: data
		})
	};

	return {
		ajax: ajax,
		validate: validate
	}

})();