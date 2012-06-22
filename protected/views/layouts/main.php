<!DOCTYPE html>
<html lang="zh-cn">
<head>
	<title><?php echo CHtml::encode(Yii::app()->name.' - '.$this->pageTitle); ?></title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="<?php echo CHtml::encode(Yii::app()->name); ?>">
	<meta name="author" content="rocwang">
	<link rel="stylesheet" href="css/style.css" media="screen" />

	<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!--link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/ico/favicon.ico">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo Yii::app()->request->baseUrl; ?>/ico/apple-touch-icon-114-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo Yii::app()->request->baseUrl; ?>/ico/apple-touch-icon-72-precomposed.png">
	<link rel="apple-touch-icon-precomposed" href="<?php echo Yii::app()->request->baseUrl; ?>/ico/apple-touch-icon-57-precomposed.png"-->
</head>
<body>
<?php $this->widget('bootstrap.widgets.BootNavbar', array(
	//'fixed'=>true,
	'fluid'=>true,
	'brand'=>Yii::app()->name,
	'collapse'=>true,
	'items'=>array(
		array(
			'class'=>'bootstrap.widgets.BootMenu',
			'items'=>array(
				array('label'=>'刷新', 'url'=>array('site/list')),
			),
		),

		CHtml::openTag('p', array('class'=>'navbar-text pull-right')).
			CHtml::tag('i', array('class'=>'icon-white icon-user'), '', true).' '.
			(Yii::app()->user->isGuest ?
				CHtml::link('登录', Yii::app()->user->loginUrl)
				:
				sprintf("%s - %s(%s) ",
					Yii::app()->user->deptName,
					Yii::app()->user->name,
					Yii::app()->user->chineseName
				) .CHtml::link('登出', array('site/logout')))
		.CHtml::closeTag('p'),
	),
)); ?>

	<div class="container-fluid" id="page">

	<?php //$this->renderPartial('//site/_alert'); ?>

	<?php if(!empty($this->breadcrumbs)) {
		$this->widget('bootstrap.widgets.BootBreadcrumbs', array(
		'links'=>$this->breadcrumbs,
	));} ?>

		<div class="row-fluid">
			<?php echo $content; ?>
		</div>

		<hr>

		<footer>
			<address class="pull-right">
				By <strong>rocwang</strong><br>
				Mar 2012<br>
				<a href="mailto:rocinwinter@gmail.com">rocinwinter@gmail.com</a><br>
				<a href="http://rocwang.me" target="_blank">http://rocwang.me</a>
			</address>
		</footer>
	</div>
</body>
</html>
