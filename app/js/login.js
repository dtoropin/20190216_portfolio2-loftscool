//= ../libs/workingForm.js

// module login
(function () {

	var _form = $('.loginForm'),
	_elements = _form.find('input').not('input[type="hidden"]');

	var init = function () {
		_setUpListners();
	};

	var _setUpListners = function () {
		_form.on('submit', _loginSend);
		_elements.on('input', _onInput);
	};

	var _onInput = function () {
		var el = $(this);
		if (el.hasClass('error')) el.removeClass('error');
	};

	var _loginSend = function (e) {
		e.preventDefault();

		var url = '/php/login.php',
			data = new FormData(this);

		if (!workingForm.validate(_form)) return false;

		workingForm.ajax(url, data).done(function (res) {
			if (res.ans === 'OK') {
				_form.trigger('reset');
				window.location.href = '/portfolio';
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
			$('.alertErrorAdd').show();
		});
	};

	return init();
})();