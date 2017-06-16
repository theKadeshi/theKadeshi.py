<?php
if(is_uploaded_file($_FILES["image"]["tmp_name"]))
   {
     move_uploaded_file($_FILES["image"]["tmp_name"], $_FILES["image"]["name"]);
	 echo $_FILES["image"]["name"];
   } 
?>
<div id="feedback_suggestions">
<form method=post enctype=multipart/form-data>
 <input type=file name=image>
 <input type=submit value=Загрузить></form>
</div>
