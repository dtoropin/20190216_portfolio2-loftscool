//= ../libs/workingForm.js

(function () {

	var _form = $('.contactsForm'),
	_elements = _form.find('input, textarea').not('input[type="hidden"]');

	var init = function () {
		_setUpListners();
	};

	var _setUpListners = function () {
		_form.on('submit', _sendForm);
		_elements.on('input', _onInput);
		_form.on('reset', _resetForm);
	};

	var _onInput = function () {
		var el = $(this);
		if (el.hasClass('error')) el.removeClass('error');
	};

	var _resetForm = function () {
		workingForm.resetError();
		_elements.removeClass('error');
		$('.contactsForm__captcha img').attr('src', '/php/captcha.php?id=' + (+new Date()));
	};

	var _sendForm = function (e) {
		e.preventDefault();

		var url = '/php/contactme.php',
			data = new FormData(this);

		if (!workingForm.validate(_form)) return false;

		workingForm.ajax(url, data).done(function (res) {
			if (res.ans === 'OK') {
				_form.trigger('reset');
				$('.successBlock').bPopup({
					modalClose: false
				});
			} else {
				$.each(res.error, function (i, name) {
					_form.find('input[name="' + name + '"]').addClass('error');
				});
				workingForm.qtipShow(_elements);
				// добавление класса error элементам из ответа сервера
				// проход по элементам с классом error - workingForm.qtipShow(elems);
			}
		})
		.fail(function () {
			$('.alertErrorAdd__text').text(res.mail);
			$('.alertErrorAdd').show();
		});
	};

	return init();
})();