$(function(){

function refresh()
{
	$('img.loader').show();

	$.getJSON('api.php', {r:'site/list'}, function(data) {
		//保存本次结果
		localStorage.clear();
		var items = data.items;
		for(var i = 0; i < items.length; i++) {
			localStorage[items[i].id] = JSON.stringify(items[i]);
		}

		render(data);

		//隐藏loader
		$('img.loader').hide();
	});
}

function render(data)
{
	var output = Mustache.render($('#greader').html(), data);
	$('#accordion').html(output);


	//初始化hammer.js
	$('.accordion-heading')
	.hammer({
		swipe_time         : 2000,
		swipe_min_distance : 100
	});
}

$('#accordion').on('swipe', '.accordion-heading', function(ev) {
	if (ev.direction === 'right') {
		$(ev.target).wrapInner('<del/>').parent().fadeOut(
			function() {
				$(this).remove();
			}
		);

		var id = $(ev.target).attr('item_id');

		$.getJSON(
			'api.php',
			{
				r  : 'site/markRead',
				id : id
			},
			function(data, textStatus, jqXHR) {
				//if (jqXHR.status === 200) {
				//}
			}
		);

		localStorage.removeItem(id);
	}
});

$('#refresh').click(refresh);

if (localStorage.length > 0) {
	var items = [];
	for(var i = 0; i < localStorage.length; i++) {
		items[i] = JSON.parse(localStorage[localStorage.key(i)]);
	}
	render({items: items});
} else {
	refresh();
}

});
