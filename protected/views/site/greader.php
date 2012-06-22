<table>
	<tr>
		<td>Title</td>
	</tr>

	<?php foreach($items as $item) { ?>
	<tr>
		<td><?php echo CHtml::link($item->title, $item->alternate[0]->href); ?></td>
	</tr>
	<?php } ?>

</table>
