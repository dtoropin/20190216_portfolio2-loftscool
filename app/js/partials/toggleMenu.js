// other
(function () {
	if($(window).width() >= 992) return false;

	var init = function () {
		_setUpListners();
	};

	var _setUpListners = function () {
		$('.hamburger').on('click', _showMenu);
	};

	var _showMenu = function (e) {
		e.preventDefault();
		e.stopPropagation();
		$('.menu').slideToggle({duration: 200});
	};

	return init();
})();