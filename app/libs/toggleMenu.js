(function () {
	if($(window).width() >= 992) return false;

	$('.hamburger').on('click', function () {
		console.log('click');
		$('.menu').slideToggle({duration: 200});
	});
})();