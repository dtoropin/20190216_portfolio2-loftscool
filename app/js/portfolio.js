//= ../libs/inputFile.js
//= ../libs/workingForm.js

(function () {

	var _MODAL = null,
		_form = $('.addprojectForm'),
		_elements = _form.find('input, textarea').not('input[type="hidden"]');

	var init = function () {
		_setUpListners();
	};

	var _setUpListners = function () {
		$('.projects-add__link').on('click', _showModal);
		$('.addprojectForm__close').on('click', _closeModal);
		_form.on('submit', _addProject);
		_elements.on('input', _onInput);
	};

	var _showModal = function (e) {
		e.preventDefault();
		if($(window).width() <= 400) var position = ['18px', 'auto'];
		_MODAL = $('.addproject').bPopup({
			modalClose: false,
			positionStyle: 'fixed',
			escClose: false,
			position: position
		});
	};

	var _closeModal = function () {
		workingForm.resetError();
		_MODAL.close();
		_form.trigger('reset');
		$('.inputFile__input').trigger('change');
		_elements.removeClass('error');
	};

	var _onInput = function (e) {
		var el = $(this);
		if (el.hasClass('error')) el.removeClass('error');
	};

	var _addProject = function (e) {
		e.preventDefault();

		var url = '/php/addproject.php',
			data = new FormData(this);

		if(!workingForm.validate(_form)) return false;

		workingForm.ajax(url, data).done(function (res) {
			if (res.ans === 'OK') {
				_closeModal();
				$('.successBlock').bPopup({
					modalClose: false,
					onClose: function () {
						window.location.href = '/portfolio';
					}
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
			$('.alertErrorAdd').show();
		});
	};

	return init();
})();