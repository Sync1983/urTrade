<?php 
    /* @var $this Controller */ 
    /* @var $billing*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta charset="utf-8"> 
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/dataTables.css" />
	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
	
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

	<div id="header">
		<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
	</div><!-- header -->

	<div id="mainmenu">
		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>'Home', 'url'=>array('/site/index')),
				array('label'=>'Цена и заказ', 'url'=>array('/site/request')),
                array('label'=>'Управление клиентами', 'url'=>array('/site/client_list'), 'visible'=>Yii::app()->user->isAdmin()),				
                array('label'=>'Корзина ('.Basket::getBasketPrice().' руб.)', 'url'=>array('/basket/basket'), 'visible'=>((!Yii::app()->user->isAdmin()))&&(!Yii::app()->user->isGuest), 'visible'=>!Yii::app()->user->isGuest),
				array('label'=>'Заказы('.Orders::getOrdersPrice().' руб.)', 'url'=>array('/orders/orders'), 'visible'=>((!Yii::app()->user->isAdmin()))&&(!Yii::app()->user->isGuest), 'visible'=>!Yii::app()->user->isGuest),
                array('label'=>'Баланс ('.Billing::model()->getBalance().' руб.)', 'url'=>array('/site/billing'), 'visible'=>!Yii::app()->user->isGuest),
				array('label'=>'Параметры', 'url'=>array('/site/settings'), 'visible'=>!Yii::app()->user->isGuest),	
                array('label'=>'О нас', 'url'=>array('/site/page', 'view'=>'about')),
				array('label'=>'Контакты', 'url'=>array('/site/contact')),
				array('label'=>'Вход', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
				array('label'=>'Выход ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
			),
		)); ?>
	</div><!-- mainmenu -->
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by ATC.<br/>				
	</div><!-- footer -->

</div><!-- page -->
<div class="preloader">
  &nbsp;
</div>
</body>
</html>
