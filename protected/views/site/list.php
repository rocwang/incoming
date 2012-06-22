<div class="accordion" id="accordion">
	<?php foreach($feeds as $index => $feed) { ?>
	<div class="accordion-group">
		<div class="accordion-heading">
			<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#feed_<?php echo $index; ?>">
				<?php echo $feed->title; ?>>
			</a>
		</div>
		<div id="feed_<?php echo $index; ?>" class="accordion-body collapse">
			<div class="accordion-inner">
				<?php
					if (isset($feed->content)) {
						echo $feed->content->content;
					}
					if (isset($feed->summary)) {
						echo $feed->summary->content;
					}
				?>>
			</div>
		</div>
	</div>
	<?php } ?>

	<?php foreach($mails as $index => $mail) { ?>
	<div class="accordion-group">
		<div class="accordion-heading">
			<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#mail_<?php echo $index; ?>">
				<?php echo imap_utf8($mail->subject); ?>>
			</a>
		</div>
		<div id="mail_<?php echo $index; ?>" class="accordion-body collapse">
			<div class="accordion-inner">
				<?php echo imap_utf8($mail->body); ?>
			</div>
		</div>
	</div>
	<?php } ?>

</div>
