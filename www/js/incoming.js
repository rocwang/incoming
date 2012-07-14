function refresh()
{
	$('img.loader').show();

	$.getJSON('api.php', {r:'site/list'}, function(data) {
		var output = Mustache.render($('#greader').html(), data);
		$('#accordion').html(output);

		//初始化hammer.js
		$('.accordion-heading')
		.hammer({
			swipe_time         : 2000,
			swipe_min_distance : 100
		});

		//隐藏loader
		$('img.loader').hide();
	});
}

$('#accordion').on('swipe', '.accordion-heading', function(ev) {
	if (ev.direction === 'right') {
		$(ev.target).wrapInner('<del/>').parent().fadeOut(
			function() {
				$(this).remove();
			}
		);

		$.getJSON(
			'api.php',
			{
				r  : 'site/markRead',
				id : $(ev.target).attr('item_id')
			},
			function(data, textStatus, jqXHR) {
				//if (jqXHR.status === 200) {
				//}
			}
		);
	}
});

$('#refresh').click(refresh);

refresh();
