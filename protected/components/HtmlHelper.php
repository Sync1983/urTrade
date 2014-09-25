<?php

class HtmlHelper {
  
  public static function AjaxButton($name,$action,$id=null,$params=[]) {
	$text = "<input type=\"button\" class=\"main-button\" onClick=\"$action\" value=\"$name\"";
	if($id){
	  $text .= " id=\"$id\" ";
	}	
	foreach ($params as $key => $value) {
	  if(is_array($value)){
		$text .= " $key = \"";
		foreach ($value as $sub_key => $sub_value) {
		  $text .= " $subkey:$sub_value";
		}
		$text .="\"";
	  } else {
		$text .= " $key=\"$value\"";
	  }
	  $text .= "/>";
	}  
	return $text;	
  }
  
  public static function span($name,$text,$class="") {
	return "<span name=\"$name\" class=\"$class\">$text</span>";
  }
  
}

