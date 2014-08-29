<?php

class RequestForm extends CFormModel
{
	public $part_id;
	public $object;
	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// name, email, subject and body are required
			array('part_id', 'required','message'=>'Заполните поле Артикул'),
		);
	}
	
	public function load_data($part_id) {
		$obj = array();
		if($part_id==$this->part_id) {
			$obj = $this->object;
		} else {
			$url = 'http://online.atc58.ru?part_id='.$part_id;
			$answer = file_get_contents($url,false);
			$obj = json_decode($answer, true);
			$this->object = $obj;
		}
		$this->part_id = $part_id;
		
		$answer = <<<TABLE
			<table class='part-table'>
				<tr class='part-table-head'>
					<th>Склад</th>					
					<th>Производитель</th>					
					<th>Артикул</th>
					<th>Наименование</th>
					<th>Цена</th>
					<th>Упаковка</th>
					<th>Срок поставки</th>
					<th>Количество</th>
					<th>Обновление цен</th>
					<th>Комментарии</th>
				</tr>
TABLE;
		foreach ($obj as $detail) {
			/*$row = "";
			/*if($detail['type'] == 'ix') {
				$row = $this->parse_ixora_detail($detail);
			} else {
				$row = $this->parse_onlain_detail($detail);
			}*/
			$row = "<tr> <td>$detail[2]</td>
								<td>$detail[3]</td>
								<td>$detail[4]</td>
								<td>$detail[5]</td>
								<td>$detail[6]</td>
								<td>$detail[7]</td>
								<td>$detail[8]</td>
								<td></td>
								<td>$detail[9]</td>
								<td>$detail[10]</td></tr>";
			$answer.= $row;
		}
		
		return $answer."</table>";
	}
	
	protected function parse_ixora_detail($detail) {
		//"type":"ix",
		//"detailnumber":"123",
		//"detailname":"\u041a\u0410\u0422\u0423\u0428\u041a\u0410 \u0417\u0410\u0416\u0418\u0413\u0410\u041d\u0418\u042f",
		//"maker_id":"972",
		//"maker_name":"TSN",
		//"quantity":"32",
		//"lotquantity":"1",
		//"price":"678.02",
		//"pricedestination":"0",
		//"days":"4",
		//"dayswarranty":"6",
		//"regionname":"\u041c\u041e\u0421\u041a\u0412\u0410 \u0421\u041a\u041b\u0410\u0414 - 53",
		//"estimation":"5 - 5",
		//"orderrefernce":"1033990-86951-2-294-1-37781083-1-0",
		//"pricedate":"2014-08-28T15:42:00+04:00",
		//"groupid":"0"}
		$date = strtotime($detail['pricedate']);		
		$data_str = date("d.m.Y H:i", $date);
		return '<tr> <td>'.$detail['regionname'].'</td>'.
								'<td>'.$detail['maker_name'].'</td>'.
								'<td>'.$detail['detailnumber'].'</td>'.
								'<td>'.$detail['detailname'].'</td>'.
								'<td>'.$detail['price'].'</td>'.
								'<td>'.$detail['lotquantity'].'</td>'.
								'<td>'.$detail['days'].'-'.$detail['dayswarranty'].'</td>'.
								'<td>'.''.'</td>'.
								'<td>'.$data_str.'</td>'.
								'<td>'.''.'</td>';
	}
	
	protected function parse_onlain_detail($detail) {
		//"type":"on",
		//"uid":"2014082911363162990021954002d7f85101",
		//"id":"1307286",
		//"dataprice":"2014.08.29 06:25",
		//"code":"75409S",
		//"producer":"RUVILLE",
		//"caption":"\u0428\u0420\u0423\u0421 VW PASSAT 32B 90GOLF IIJETTA II",
		//"price":"801",
		//"rest":"5",
		//"deliverydays":"0",
		//"delivery":" \u0446\u0435\u043d\u0430 \u0441 \u0434\u043e\u0441\u0442.",
		//"currency":"R",
		//"analog":"+",
		//"stock":"STOCK763",
		//"amount":"",
		//"stockinfo":"\u0417\u0430\u043a\u0430\u0437\u044b \u0440\u0430\u0437\u043c\u0435\u0449\u0451\u043d\u043d\u044b\u0435 \u0434\u043e 11-30 \u0432\u044b\u043f\u043e\u043b\u043d\u044f\u044e\u0442\u0441\u044f \u0432 \u044d\u0442\u043e\u0442 \u0436\u0435 \u0434\u0435\u043d\u044c \u0434\u043e 20-00. \n\u0418\u043d\u0444\u043e\u0440\u043c\u0430\u0446\u0438\u044f \u043f\u043e \u043f\u043e\u0432\u043e\u0434\u0443 \u0431\u0440\u0430\u043a\u0430, \u043d\u0435\u0434\u043e\u0432\u043e\u0437\u0430, \u043f\u0435\u0440\u0435\u0441\u043e\u0440\u0442\u0430 \u0434\u043e\u0441\u0442\u0443\u043f\u043d\u0430 \u043d\u0430 \u0441\u043b\u0435\u0434\u0443\u044e\u0449\u0438\u0439 \u0440\u0430\u0431\u043e\u0447\u0438\u0439 \u0434\u0435\u043d\u044c.\n\u0417\u0430\u043a\u0430\u0437\u044b \u0440\u0430\u0437\u043c\u0435\u0449\u0451\u043d\u043d\u044b\u0435 \u043d\u0430 \u0434\u0430\u043d\u043d\u043e\u043c \u0441\u0442\u043e\u043a\u0435 \u0441\u043d\u044f\u0442\u044c, \u0432\u0435\u0440\u043d\u0443\u0442\u044c \u043d\u0435 \u0432\u043e\u0437\u043c\u043e\u0436\u043d\u043e."
		//$date = strtotime($detail['dataprice']);		
		$data_str = $detail['dataprice'];// date("d.m.Y H:i", $date);
		return '<tr> <td>'.$detail['stock'].'</td>'.
								'<td>'.$detail['producer'].'</td>'.
								'<td>'.$detail['code'].'</td>'.
								'<td>'.$detail['caption'].'</td>'.
								'<td>'.$detail['price'].'</td>'.
								'<td>'.$detail['amount'].'</td>'.
								'<td>'.$detail['deliverydays'].'</td>'.
								'<td>'.''.'</td>'.
								'<td>'.$data_str.'</td>'.
								'<td>'.''.'</td>';
	}
}