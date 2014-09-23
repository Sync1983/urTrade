<?php
class ProviderIxora extends Provider {
  
  protected $_contract_id="";

  public function __construct($login, $password, $data = null) {
	parent::__construct($login, $password, $data);
    $this->_CLSID = 542;
  }

  public function loadPart($uid,$part_id,$maker_id) {
	/* @var $part Part */
    $part =  parent::loadHashPart(self::PartPrefix.$this->getCLSID()."_".$part_id."_".$maker_id,$uid);
    $part = json_decode($part,true);
    $part_out = new Part();
    $part_out->setAttributes($part,false);
    return $part_out;
  }

  public function loadPartList($part_id,$maker_id = null){
	$all = $this->loadCache(self::PartPrefix.$this->getCLSID()."_".$part_id."_".$maker_id);
	if(is_array($all)&&(count($all)>0)) {
	$answer = array();
	foreach ($all as $name=>$item){
	  $answer[$name] = json_decode($item);
       }
       return $answer;
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://ws.auto-iksora.ru:83/searchdetails/searchdetails.asmx/FindDetailsXML");
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_VERBOSE, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $post = array(
              'DetailNumber'  => $part_id,
			  'MakerID'               => $maker_id,
              'ContractID'    => $this->_contract_id,
              'Login'         => $this->_login,
              'Password'      => $this->_pass,
      );
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));

    $site_answer = curl_exec($ch);
    curl_close($ch);
	libxml_use_internal_errors(true);
    try{
      $xml = new SimpleXMLElement($site_answer);
    } catch (ErrorException $error) {
      YII::log($error->getMessage().":".$site_answer,"error","system.web");
	  return array();
    }
	libxml_use_internal_errors(false);
    $result = array();
    foreach($xml->row as $row){
      $part = new Part();
      $time = strtotime($row->pricedate);
      $part->setValues(     strval($row->orderrefernce),
                                            $this->getCLSID(),
                                            strval($row->detailnumber),
                                            strval($row->maker_name),
                                            strval($maker_id),
                                            strval($row->detailname),
                                            strval($row->price),
                                            strval($row->days),
                                            strval($row->regionname),
                                            "",
                                            strval($time),
                                            (intval($row->groupid)==0),
                                            strval($row->quantity),
                                            strval($row->lotquantity)
            );
      $this->saveCache(self::PartPrefix.$this->getCLSID()."_".$part_id."_".$maker_id,strval($row->orderrefernce), $part,12*3600);
      $result[] = $part;
    }
    return $result;
  }


  public function loadPartProducer($part_id) {
    $all = $this->loadCache(self::ProducerPrefix.$this->getCLSID()."_".$part_id);
    if(is_array($all)&&(count($all)>0)) {
	  return $all;
    }

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://ws.auto-iksora.ru:83/searchdetails/searchdetails.asmx/GetMakersByDetailNubmerXML");
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_VERBOSE, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $post = array(
            'DetailNumber'  => $part_id,
            'ContractID'    => $this->_contract_id,
            'Login'         => $this->_login,
            'Password'      => $this->_pass,
    );
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
    $site_answer = curl_exec($ch);
    curl_close($ch);
    libxml_use_internal_errors(true);
    try{
	  $xml = new SimpleXMLElement($site_answer);
    } catch (Exception $error) {
	  YII::log($error->getMessage().":".$site_answer,"error","system.web");
      return array();
    }
	libxml_use_internal_errors(false);
    $answer = array();
    foreach($xml->row as $row){
	  $answer[strval($row->name)] = intval($row->id);
	  $this->saveCache(self::ProducerPrefix.$this->getCLSID()."_".$part_id,strval($row->name),intval($row->id),12*3600);
	}
	return $answer;
  }
}
