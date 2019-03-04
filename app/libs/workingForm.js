// workingForm (ajax, validate)
var workingForm = (function () {

	var _createQtip = function (element, position) {
		// target для custom input 'file'
		var target = element.attr('type') === 'file' ? element.siblings('span') : element;
		// позиция тултипа
		if (position === 'right') {
			position = {
				my: 'center left',
				at: 'center right',
				target: target,
				adjust: {
					scroll: false
				}
			}
		} else {
			position = {
				my: 'center right',
				at: 'center left',
				target: target,
				adjust: {
					scroll: false
				}
			}
		}

		// инициализация тултипа
		element.qtip({
			content: {
				text: function () {
					return $(this).attr('data-tooltip');
				}
			},
			show: {
				event: 'show'
			},
			hide: {
				event: 'change keydown hideTooltip'
			},
			position: position,
			style: {
				classes: 'qtip-mystyle',
				tip: {
					border: 0,
					heigth: 12,
					width: 16
				}
			}
		}).trigger('show');
	};

	var qtipShow = function (elems) {
		if($(window).width() <= 768) return false;
		$.each(elems, function (i, val) {
			if (val.classList.contains('error')) {
				var pos = val.hasAttribute('data-tooltip-position')
					? val.getAttribute('data-tooltip-position')
					: 'left';
				_createQtip($(val), pos);
			}
		});
	};

	var resetError = function () {
		$('.qtip').hide();
		$('.alertErrorAdd').hide();
	};

	var validate = function (form) {
		var elems = $(form).find('input, textarea').not('input[type="hidden"]'),
			valid = true;

		$.each(elems, function (i, val) {
			if (val.value.length === 0) {
				val.classList.add('error');
				valid = false;
			}
		});
		qtipShow(elems);
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
		validate: validate,
		resetError: resetError,
		qtipShow: qtipShow
	}

})();