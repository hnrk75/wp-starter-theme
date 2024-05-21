document.addEventListener('DOMContentLoaded', function() {
	var searchToggle = document.querySelector('.search-toggle');
	var searchIcons = document.querySelectorAll('.search-toggle button');
	var searchContainer = document.querySelector('.search-container');
	var searchTerms = document.querySelector('#search-terms');

	// Accordion effect on searchbar
	searchToggle.classList.add('closing');

	searchIcons.forEach(function(icon) {
		icon.addEventListener('click', function() {
			if (searchToggle.classList.contains('closing')) {
				searchToggle.classList.remove('closing');
				searchToggle.classList.add('opening');
				searchContainer.classList.add('opening');
				searchTerms.focus();
			} else {
				searchToggle.classList.remove('opening');
				searchToggle.classList.add('closing');
				searchContainer.classList.remove('opening');
			}
		});
	});
});
