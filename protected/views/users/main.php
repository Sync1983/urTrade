<h5>Общие данные</h5>

<div class="form">	
	<?php echo CHtml::hiddenField('id',$id); ?>
  
	<div class="row">
		<?php echo CHtml::label("Пользователь",'username'); ?>
		<?php echo HtmlHelper::span('username',$user->username); ?>		
	</div>
	
	<div class="row">
	  <?php echo CHtml::label("Тип",'type'); ?>
	  <?php echo HtmlHelper::span('type',$info->type==1?"Частное лицо":"Юр. лицо"); ?>			  
	</div>	
  
	<div class="row">
	  <?php echo CHtml::label("Баланс",'balance'); ?>
	  <?php echo HtmlHelper::span('balance',$balance); ?>			  
	</div>	
  
	<div class="row">
	  <?php echo CHtml::label("Предоставленный кредит",'credit'); ?>
	  <?php echo HtmlHelper::span('credit',$credit); ?>			  
	</div>	
  
	<div class="row">
	  <?php echo CHtml::label("Корзина",'basket'); ?>
	  <?php echo HtmlHelper::span('basket',"$basket_count товаров на сумму $basket_price руб."); ?>			  
	</div>	
  
	<div class="row">
	  <?php echo CHtml::label("Заказы",'orders'); ?>
	  <?php echo HtmlHelper::span('order',"$order_count товаров на сумму $order_price руб."); ?>			  
	</div>	

  <form id="main-form">
	<div class="row">
	  <?php echo CHtml::label("Наценка, %",'price_percent'); ?>
	  <?php echo CHtml::numberField('price_percent',$user->price_percent); ?>			  
	</div>	
	
	<div class="row">
	  <?php echo CHtml::label("Время доставки, дн",'shiping_time'); ?>
	  <?php echo CHtml::numberField('shiping_time',$user->shiping_time); ?>			  
	</div>	
  </form>
	<div class="row buttons">
	  <?php echo HtmlHelper::AjaxButton('Изменить', "ajaxSend('#main-form','".$this->createUrl("/users/mainSave")."',true)");?>		
	</div>
  
  <form id="password-form">
	<div class="row">
	  <?php echo CHtml::label("Пароль",'password'); ?>
	  <?php echo CHtml::textField('password',""); ?>
	</div>	
  </form>
	<div class="row buttons">
	  <?php echo HtmlHelper::AjaxButton('Изменить', "ajaxSend('#password-form','".$this->createUrl("/users/mainSavePassword")."',true)");?>		
	</div>
  
  <form id="billing-form">
	<div class="row">
	  <?php echo CHtml::label("Баланс",'billing_value'); ?>
	  <?php echo CHtml::numberField('billing_value',""); ?>
	  <?php echo CHtml::label("Комментарий",'billing_comment'); ?>
	  <?php echo CHtml::textField('billing_comment',""); ?>
	</div>	
  </form>
	<div class="row buttons">
	  <?php echo HtmlHelper::AjaxButton('Изменить', "ajaxSend('#billing-form','".$this->createUrl("/users/mainSaveBilling")."',true)");?>		
	</div>
</div><!-- form -->
<div id="prices-list">
  <?php   /*echo $prices;*/ ?>
</div>
	
