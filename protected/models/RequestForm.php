<?php

class RequestForm extends CFormModel
{
	public $part_id;
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
}