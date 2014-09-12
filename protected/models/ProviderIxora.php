<?php
class ProviderIxora extends ProviderController {
    protected $_contract_id="";
    
    public function loadPartList($part_id) {
        throw new Exception("Use parent method");
    }
    
    public function loadPartProducer($part_id) {
        $all = $this->_cache->hget(self::ProducerPrefix.  get_class($this), $part_id);
        if($all)
            return json_decode ($all,true);
        
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
        $xml = new SimpleXMLElement($site_answer);
        $answer = array();
        foreach($xml->row as $row){  
            $pProd = new PartProducer();
            $pProd->id = intval($row->id);
            $pProd->name = strval($row->name);
            $pProd->producer = get_class($this);
            $answer[$pProd->name] = $pProd;
        }
        $this->_cache->hset(self::ProducerPrefix.  get_class($this), $part_id, json_encode($answer));
        return $answer;
    }
}
