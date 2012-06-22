<?php $this->beginContent('//layouts/main'); ?>
<div class="span3">
	<div class="well sidebar-nav">
		<?php $this->widget('bootstrap.widgets.BootMenu', array(
			'type'=>'list',
			'items'=>$this->menu,
		)); ?>
	</div>
</div>
<div class="span9">
	<?php echo $content; ?>
</div>
<?php $this->endContent(); ?>
