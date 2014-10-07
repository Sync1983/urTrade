<?php

class Mailer{
  
  protected $toAddres="sales@atc58.ru";
  protected $config;
  
  public function __construct() {
	ini_set('sendmail_from', 'sales@atc58.ru');
	ini_set('SMTP', 'mail.atc58.ru');
	$this->config['smtp_username'] = 'sales@atc58.ru';  //Смените на имя своего почтового ящика.
	$this->config['smtp_port']     = '25'; // Порт работы. Не меняйте, если не уверены.
	$this->config['smtp_host']     = 'mail.atc58.ru';  //сервер для отправки почты(для наших клиентов менять не требуется)
	$this->config['smtp_password'] = 'q2w3e4r5t6';  //Измените пароль
	$this->config['smtp_debug']    = false;  //Если Вы хотите видеть сообщения ошибок, укажите true вместо false
	$this->config['smtp_charset']  = 'utf-8';   //кодировка сообщений. (или UTF-8, итд)
	$this->config['smtp_from']     = 'АвтоТехСнаб'; //Ваше имя - или имя Вашего сайта. Будет показывать при прочтении в поле "От кого"
  }
  

  function smtpmail($mail_to, $subject, $message, $headers='') {         
        $SEND =   "Date: ".date("D, d M Y H:i:s") . " UT\r\n";
        $SEND .=   'Subject: =?'.$this->config['smtp_charset'].'?B?'.base64_encode($subject)."=?=\r\n";
        if ($headers) $SEND .= $headers."\r\n\r\n";
        else
        {
                $SEND .= "Reply-To: ".$this->config['smtp_username']."\r\n";
                $SEND .= "MIME-Version: 1.0\r\n";
                $SEND .= "Content-Type: text/html; charset=\"".$this->config['smtp_charset']."\"\r\n";
                $SEND .= "Content-Transfer-Encoding: 8bit\r\n";
                $SEND .= "From: \"".$this->config['smtp_from']."\" <".$this->config['smtp_username'].">\r\n";
                $SEND .= "To: $mail_to <$mail_to>\r\n";
                $SEND .= "X-Priority: 3\r\n\r\n";
        }
        $SEND .=  $message."\r\n";
         if( !$socket = fsockopen($this->config['smtp_host'], $this->config['smtp_port'], $errno, $errstr, 30) ) {
            if ($this->config['smtp_debug']) echo $errno."&lt;br&gt;".$errstr;
            return false;
         }

            if (!$this->server_parse($socket, "220", __LINE__)) return false;

            fputs($socket, "HELO " . $this->config['smtp_host'] . "\r\n");
            if (!$this->server_parse($socket, "250", __LINE__)) {
               if ($this->config['smtp_debug']) echo '<p>Не могу отправить HELO!</p>';
               fclose($socket);
               return false;
            }
            fputs($socket, "AUTH LOGIN\r\n");
            if (!$this->server_parse($socket, "334", __LINE__)) {
               if ($this->config['smtp_debug']) echo '<p>Не могу найти ответ на запрос авторизаци.</p>';
               fclose($socket);
               return false;
            }
            fputs($socket, base64_encode($this->config['smtp_username']) . "\r\n");
            if (!$this->server_parse($socket, "334", __LINE__)) {
               if ($this->config['smtp_debug']) echo '<p>Логин авторизации не был принят сервером!</p>';
               fclose($socket);
               return false;
            }
            fputs($socket, base64_encode($this->config['smtp_password']) . "\r\n");
            if (!$this->server_parse($socket, "235", __LINE__)) {
               if ($this->config['smtp_debug']) echo '<p>Пароль не был принят сервером как верный! Ошибка авторизации!</p>';
               fclose($socket);
               return false;
            }
            fputs($socket, "MAIL FROM: <".$this->config['smtp_username'].">\r\n");
            if (!$this->server_parse($socket, "250", __LINE__)) {
               if ($this->config['smtp_debug']) echo '<p>Не могу отправить комманду MAIL FROM: </p>';
               fclose($socket);
               return false;
            }
            fputs($socket, "RCPT TO: <" . $mail_to . ">\r\n");

            if (!$this->server_parse($socket, "250", __LINE__)) {
               if ($this->config['smtp_debug']) echo '<p>Не могу отправить комманду RCPT TO: </p>';
               fclose($socket);
               return false;
            }
            fputs($socket, "DATA\r\n");

            if (!$this->server_parse($socket, "354", __LINE__)) {
               if ($this->config['smtp_debug']) echo '<p>Не могу отправить комманду DATA</p>';
               fclose($socket);
               return false;
            }
            fputs($socket, $SEND."\r\n.\r\n");

            if (!$this->server_parse($socket, "250", __LINE__)) {
               if ($this->config['smtp_debug']) echo '<p>Не смог отправить тело письма. Письмо не было отправленно!</p>';
               fclose($socket);
               return false;
            }
            fputs($socket, "QUIT\r\n");
            fclose($socket);
            return TRUE;
  }
  
  function server_parse($socket, $response, $line = __LINE__) {  
	$server_response = "";
    while (substr($server_response, 3, 1) != ' ') {
        if (!($server_response = fgets($socket, 256))) {
                   if ($this->config['smtp_debug']) echo "<p>Проблемы с отправкой почты!</p>$response<br>$line<br>";
                   return false;
                }
    }
    if (!(substr($server_response, 0, 3) == $response)) {
           if ($this->config['smtp_debug']) echo "<p>Проблемы с отправкой почты!</p>$response<br>$line<br>";
           return false;
        }
    return true;
  }

  protected function self_mail($addr,$subject,$message,$header){
	//$this->smtpmail($addr, $subject, $message,$header);
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
	$subject = "Изменение состояния заказа";
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
	$subject = "Новый заказ";
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
