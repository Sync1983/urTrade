<?php
class ProviderIxora extends Provider {
  
  protected $_contract_id="";

  public function __construct($login, $password, $data = null) {
	parent::__construct($login, $password, $data);
    $this->_CLSID = 542;
  }
  	
  public function getName() {
	return 'Ixora';
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
    curl_setopt($ch, CURLOPT_URL, "http://ws.ixora-auto.ru/soap/ApiService.asmx/FindXML");
      curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_VERBOSE, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    $post = array(
              'Number'  => $part_id,
              'Maker'               => $maker_id,
//              'ContractID'    => $this->_contract_id,
              'Login'         => $this->_login,
              'AuthCode'      => '6632B57702F6F9416B71F9BCD874AD38',
              'StockOnly'     => 'false',
              'SubstFilter'   => 'All'
//              'Password'      => $this->_pass,
      );
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
    $site_answer = curl_exec($ch);
    curl_close($ch);
    if( !$site_answer ){
      return array();
    }
	libxml_use_internal_errors(true);
    try{
      $xml = new SimpleXMLElement($site_answer);
    } catch (Exception $error) {
      YII::log($error->getMessage().":".$site_answer,"error","system.web");
	  return array();
    }
	libxml_use_internal_errors(false);
    if( $xml === false ){
      return array();
    }
    $result = array();
    foreach($xml->DetailInfo as $row){
      $part = new Part();
      $time = strtotime($row->date);	  
      $part->setValues(						strval($row->orderrefernce),
                                            $this->getCLSID(),
                                            strval($row->number),
                                            strval($row->maker),
                                            strval($maker_id),
                                            strval($row->name),
                                            strval($row->price),
                                            strval($row->dayswarranty),
                                            strval($row->region),
                                            "",
                                            intval($time),
                                            ($row->group=="Original"),
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
    curl_setopt($ch, CURLOPT_URL, "http://ws.ixora-auto.ru/soap/ApiService.asmx/GetMakersXML");
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_VERBOSE, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    $post = array(
            'Number'  => $part_id,
//            'ContractID'    => $this->_contract_id,
            'Login'         => $this->_login,
	    'AuthCode'      => '6632B57702F6F9416B71F9BCD874AD38'
//            'Password'      => $this->_pass,
    );
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
    $site_answer = curl_exec($ch);
    curl_close($ch);
    if( !$site_answer ){
      return array();
    }
    libxml_use_internal_errors(true);
    try{
	  $xml = new SimpleXMLElement($site_answer);
    } catch (Exception $error) {
	  YII::log($error->getMessage().":".$site_answer,"trace","system.web");
      return array();
    }
	libxml_use_internal_errors(false);
    if( $xml === false ){
      return array();
    }
    $answer = array();
    foreach($xml->MakerInfo as $row){
	  $answer[strval($row->name)] = strval($row->name);//intval($row->id);
	  $this->saveCache(self::ProducerPrefix.$this->getCLSID()."_".$part_id,strval($row->name),intval($row->id),12*3600);
	}
	return $answer;
  }
}
