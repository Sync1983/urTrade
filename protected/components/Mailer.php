<?php

class Mailer{
  
  protected $toAddres="sales@atc58.ru";
  
  public function __construct() {
	ini_set('sendmail_from', 'sales@atc58.ru');
	ini_set('SMTP', 'mail.atc58.ru');
  }

  protected function self_mail($addr,$subject,$message,$header){
	/*smp
    $mail =& Mail::factory('smtp', array('host' => 'localhost', 'port' => 25)); 
	$mail->send($addr, $header, $message); */
	mail($addr, $subject, $message,$header);
  }

  /* @var $order Orders */
  function SendStateNotification($order,$new_state,$to=null){
	$states = array(
	  0 => 'Ожидает заказа',
	  1 => 'Заказан',
	  2 => 'На складе',
	  3 => 'Выдан',
	  4 => 'Отказ'		
	);
	$text_state = $states[$new_state];
	$subject = "=?utf-8?b? ".base64_encode("Изменение состояния заказа")." ?=";
	$message = "<html>".
		"  <head> " .
		"	<title>Состояние Вашего заказа изменилось</title> ".
		"  </head> ".
		"  <body> ".
		"	<h3>Заказ № ".sprintf("%07d", $order->list_id)."</h3>".
		"	Новое состояние заказа:<h3> $text_state</h3>".		
		"	№".sprintf("%07d", $order->id).": ".$order->articul." - ".$order->producer." - ".$order->name.
		"  </body> ".
		"</html>";
	$headers  = "Content-type: text/html; charset=\"utf-8\" \r\n"; 
	$headers .= "From: АвтоТехСнаб<sales@atc58.ru>\r\n"; 	
	$headers .= "Subject: $subject\r\n"; 	
	if(!$to){
	  $to = $this->toAddres;
	}
	if(!$this->self_mail($to, $subject, $message,$headers)){
		YII::trace("mail error","mailer error");
	}
  }
  
  function SendAddNewOrders($orders){
	$subject = "=?utf-8?b? ".base64_encode("Новый заказ")." ?=";
	$message = "<html>".
		"  <head> " .
		"	<title>Добавлены новые заказы</title> ".
		"  </head> ".
		"  <body> ".
		"	<table style=\"width: 100%;border-collapse: collapse;\">".
		"	<thead>".
		"	   <th align=\"center\" valign=\"middle\" style=\"border: 1px solid #000;\">Номер группы	  </th>	".
			"  <th align=\"center\" valign=\"middle\" style=\"border: 1px solid #000;\">Номер заказа	  </th>	".
			"  <th align=\"center\" valign=\"middle\" style=\"border: 1px solid #000;\">Покупатель		  </th>	".
			"  <th align=\"center\" valign=\"middle\" style=\"border: 1px solid #000;\">Сток			  </th>	".
			"  <th align=\"center\" valign=\"middle\" style=\"border: 1px solid #000;\">Деталь			  </th>	".
			"  <th align=\"center\" valign=\"middle\" style=\"border: 1px solid #000;\">Цена, руб		  </th>	".
			"  <th align=\"center\" valign=\"middle\" style=\"border: 1px solid #000;\">Доставка		  </th>	".
			"  <th align=\"center\" valign=\"middle\" style=\"border: 1px solid #000;\">Ориг			  </th>	".
			"  <th align=\"center\" valign=\"middle\" style=\"border: 1px solid #000;\">Кол-во		  </th>	".
			"  <th align=\"center\" valign=\"middle\" style=\"border: 1px solid #000;\">Комментарий	  </th>	".
		"</thead><tbody>";
	
	$provider_list = new ProviderList();
	/* @var $order Orders */	
	foreach ($orders as $order) {
	  $provider = $provider_list->getProviderByCLSID($order->provider)->getName();	  
	  $user = UserInfo::load($order->uid)->caption;
	  $message .= "<tr style=\"width: 100%;\">"
		."<td align=\"center\" valign=\"middle\" style=\"border: 1px solid #000;\">".sprintf("%07d", $order->id)."</td>		"		
		."<td align=\"center\" valign=\"middle\" style=\"border: 1px solid #000;\">".sprintf("%07d", $order->list_id)."</td>		"
		."<td align=\"center\" valign=\"middle\" style=\"border: 1px solid #000;\">$user</td>		"
		."<td align=\"center\" valign=\"middle\" style=\"border: 1px solid #000;\">$provider<br>$order->stock</td>		"
		."<td align=\"center\" valign=\"middle\" style=\"border: 1px solid #000;\">$order->articul<br>$order->producer<br>$order->name</td>	"			
		."<td align=\"center\" valign=\"middle\" style=\"border: 1px solid #000;\">$order->price</td>		"
		."<td align=\"center\" valign=\"middle\" style=\"border: 1px solid #000;\">$order->shiping</td>		"
		."<td align=\"center\" valign=\"middle\" style=\"border: 1px solid #000;\">".(($order->is_original==1)?"Да":"Нет")."</td>				"
		."<td align=\"center\" valign=\"middle\" style=\"border: 1px solid #000;\">$order->count<br>(уп.".$order->lot_party."шт)</td>		"
		."<td align=\"center\" valign=\"middle\" style=\"border: 1px solid #000;\">&nbsp $order->comment</td>"
		. "</tr>";	  
	}		  
	$message.="</tbody> </table> ".
		"  </body> ".
		"</html>";
	$headers  = "Content-type: text/html; charset=\"utf-8\" \r\n"; 
	$headers .= "From: АвтоТехСнаб Внутреннее<sales@atc58.ru>\r\n"; 	
	$headers .= "Subject: $subject\r\n"; 	
	
	$this->self_mail($this->toAddres, $subject, $message,$headers);
  }
  
}
