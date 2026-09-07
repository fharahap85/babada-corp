/* WPZOOM Click-to-Chat — Corner launcher toggle */
(function () {
	'use strict';

	var widget   = document.getElementById('wpzoom-ctc-widget');
	var launcher = widget && widget.querySelector('.wpzoom-ctc-launcher');
	var buttons  = widget && widget.querySelector('.wpzoom-ctc-buttons');

	if (!widget || !launcher) {
		return;
	}

	function open() {
		widget.classList.add('is-open');
		launcher.setAttribute('aria-expanded', 'true');
		if (buttons) {
			buttons.removeAttribute('aria-hidden');
		}
	}

	function close() {
		widget.classList.remove('is-open');
		launcher.setAttribute('aria-expanded', 'false');
		if (buttons) {
			buttons.setAttribute('aria-hidden', 'true');
		}
	}

	function toggle() {
		widget.classList.contains('is-open') ? close() : open();
	}

	launcher.addEventListener('click', function (e) {
		e.stopPropagation();
		toggle();
	});

	document.addEventListener('click', function (e) {
		if (widget.classList.contains('is-open') && !widget.contains(e.target)) {
			close();
		}
	});

	document.addEventListener('keydown', function (e) {
		if (e.key === 'Escape' && widget.classList.contains('is-open')) {
			close();
			launcher.focus();
		}
	});
})();
