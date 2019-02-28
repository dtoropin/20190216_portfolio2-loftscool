//= ../libs/inputFile.js
//= ../libs/workingForm.js

(function () {

	var _MODAL = null,
		_form = $('.addprojectForm'),
		_elements = _form.find('input, textarea');

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
		_MODAL = $('.addproject').bPopup({
			modalClose: false,
			positionStyle: 'fixed'
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
			form = e.target,
			data = new FormData(form);

		if(!workingForm.validate(form)) return false;

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
					$(form).find('input[name="' + name + '"]').addClass('error');
				});
				var elems = $(form).find('input, textarea').not('input[type="hidden"]');
				workingForm.qtipShow(elems);
				// добавление класса error элементам из ответа сервера
				// проход по элементам с классом error - workingForm.qtipShow(elems);
				// text - data-uncorrect-tooltip
			}
		})
		.fail(function () {
			$('.alertErrorAdd').show();
			console.log(error);
		});
	};

	return init();
})();