<?php
if ($mode=='upload') {
   if(is_uploaded_file($_FILES["filename"]["tmp_name"]))
   {
     move_uploaded_file($_FILES["filename"]["tmp_name"], $_FILES["filename"]["name"]);
	 echo $_FILES["filename"]["name"];
   } 
} 
?>