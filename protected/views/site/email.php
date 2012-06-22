<table>
	<tr>
		<td>From</td>
		<td>Date</td>
		<td>Subject</td>
	</tr>

	<?php foreach($overviews as $overview) { ?>
	<tr>
		<td><?php echo imap_utf8($overview->from); ?></td>
		<td><?php echo $overview->date; ?></td>
		<td><?php echo CHtml::link(imap_utf8($overview->subject), array('site/read', 'uid' => $overview->uid)); ?></td>
	</tr>
	<?php } ?>

</table>
