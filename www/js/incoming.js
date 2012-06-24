$('#accordion').on('swipe', '.accordion-heading', function(ev) {
	if (ev.direction === 'right') {
		$(ev.target).wrapInner('<del/>');
		$.getJSON(
			'index.php',
			{
				r  : 'site/markRead',
				id : $(ev.target).attr('item_id')
			},
			function(data, textStatus, jqXHR) {
				if (jqXHR.status === 200) {
					$(ev.target).parent().fadeOut(
						function() {
							$(this).remove();
						}
					);
				}
			}
		);
	}
});

$('.accordion-heading')
.hammer({
	swipe_time         : 2000,
	swipe_min_distance : 100
});
