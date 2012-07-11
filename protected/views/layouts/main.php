<!DOCTYPE html>
<html lang="zh-cn">
<head>
	<title><?php echo CHtml::encode(Yii::app()->name.' - '.$this->pageTitle); ?></title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="<?php echo CHtml::encode(Yii::app()->name); ?>">
	<meta name="author" content="rocwang">
	<meta name="apple-mobile-web-app-capable" content="yes" />

	<link rel="stylesheet" href="css/style.css" media="screen" />
	<link rel="icon" type="image/png" href="<?php echo Yii::app()->baseUrl; ?>/img/apple-touch-icon-114.png" />
	<link rel="apple-touch-icon" sizes="114x114" href="<?php echo Yii::app()->baseUrl; ?>/img/apple-touch-icon-114.png">
	<!--<link rel="apple-touch-startup-image" href="/startup.png">-->

	<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
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
		<div class="row-fluid">
			<?php echo $content; ?>
		</div>
	</div>
<?php
	Yii::app()->clientScript->registerScriptFile(
		Yii::app()->baseUrl.'/js/hammer.js',
		CClientScript::POS_END
	)->registerScriptFile(
		Yii::app()->baseUrl.'/js/jquery.hammer.js',
		CClientScript::POS_END
	)->registerScriptFile(
		Yii::app()->baseUrl.'/js/incoming.js',
		CClientScript::POS_END
	);
?>
</body>
</html>
