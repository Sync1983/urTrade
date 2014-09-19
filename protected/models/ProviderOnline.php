<?php
class ProviderOnline extends Provider {    
	
	public function __construct($login, $password, $data = null) {
	  parent::__construct($login, $password, $data);
	  $this->_CLSID	= 325;
	}
	
	public function loadPart($uid,$part_id,$maker_id) {
	  /* @var $part Part */
	  $part =  parent::loadHashPart(self::PartPrefix.$this->getCLSID()."_".$part_id."_".$maker_id,$uid);
	  if($part){
		$part = json_decode($part,true);
		$part['id'] = str_replace($part['stock'], "", $part['id']);
	  }		
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
	  $get	= array(                
                'ident'    => $maker_id,
                'login'         => $this->_login,
                'password'      => $this->_pass,
        );
	  $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, "http://onlinezakaz.ru/xmlprice.php?".http_build_query($get));
      curl_setopt($ch, CURLOPT_HEADER, 0);
      curl_setopt($ch, CURLOPT_POST, 0);
      curl_setopt($ch, CURLOPT_VERBOSE, false);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);       
	  
	  $site_answer = curl_exec($ch);
      curl_close($ch);
	  try{
		$xml = new SimpleXMLElement($site_answer,LIBXML_NOCDATA);
	  } catch (ErrorException $error) {
		return $error->getMessage().":".$site_answer;
	  }	  
	  $result = array();	  
	  foreach($xml->detail as $row){
		$part = new Part();
		$row->dataprice = str_replace(".", "-", $row->dataprice);
		$time = strtotime($row->dataprice);		
		$part->setValues(	strval($row->uid).strval($row->stock), 
							$this->getCLSID(), 
							strval($row->code),
							strval($row->producer),
							strval($maker_id),
							strval($row->caption),
							strval($row->price),
							strval($row->deliverydays),
							strval($row->stock),
							strval($row->stockinfo), 
							strval($time),
							(strval($row->analog)!=="+"),
							strval($row->rest),
							strval($row->amount)
			);
		  $this->saveCache(self::PartPrefix.$this->getCLSID()."_".$part_id."_".$maker_id,strval($row->uid).strval($row->stock), $part,3600);
		  $result[] = $part;
		}				
		return $result;	  
	}


	public function loadPartProducer($part_id) {        
		$all = $this->loadCache(self::ProducerPrefix.$this->getCLSID()."_".$part_id);	
		if(is_array($all)&&(count($all)>0)) {		  
            return $all;
		}
        $get = array(
                'code'			=> $part_id,
				'sm'			=> "1",
                'login'         => $this->_login,
                'password'      => $this->_pass,
        );	  
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://onlinezakaz.ru/xmlprice.php?".http_build_query($get));
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_VERBOSE, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);                
        $site_answer = curl_exec($ch);
        curl_close($ch);
		libxml_use_internal_errors(true);
        try{
		  $xml = new SimpleXMLElement($site_answer);
		} catch (Exception $error) {
		  echo $error->getMessage().":".$site_answer;
		  return array();
		}		
        $answer = array();
        foreach($xml->detail as $row){            
            $answer[strval($row->producer)] = intval($row->ident);
			$this->saveCache(self::ProducerPrefix.$this->getCLSID()."_".$part_id,strval($row->producer),intval($row->ident));
		}	
        return $answer;
    }
}
