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
				<tr>
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
			$row = "";
			if($detail['type'] == 'ix') {
				$row = $this->parse_ixora_detail($detail);
			} else {
				
			}
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
}