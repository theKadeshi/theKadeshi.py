<?php
	header ("Cache-Control: no-cache, must-revalidate"); 
	header ("Pragma: no-cache");

	require( "includes/PEAR.php" );

	$errorStr = null;
	$fatalError = false;

	error_reporting (E_ERROR | E_WARNING | E_PARSE);

	@ini_set( 'memory_limit', '64M' );

	if ( version_compare(PHP_VERSION,'5','>=') ) {
		require_once( "domxml-php4-to-php5.php" );
		define( "PHP5", true );
	} else
		define( "PHP5", false );

	define( 'SYS_VERSION_FILE', 'kernel/wbs.xml' );

	function fileContent( $filePath )
	{
		$content = file( $filePath );
		return implode( '', $content );
	}

	function getSystemVersion()
	{
		$content = fileContent( SYS_VERSION_FILE );

		$dom = @domxml_open_mem( $content );
		if ( !$dom )
			return PEAR::raiseError( "Error opening version file" );

		$xpath = @xpath_new_context($dom);

		$nodePath = '/WBS';
		if ( !( $versionnode = &xpath_eval($xpath, $nodePath) ) )
			return PEAR::raiseError( "Error parsing version file" );
			
		if ( !count($versionnode->nodeset) )
			return PEAR::raiseError( "Invalid version file" );
			
		$versionnode = $versionnode->nodeset[0];
		$versionValue = $versionnode->get_attribute( 'VERSION' );

		if ( !strlen($versionValue) )
			return PEAR::raiseError( "Version information is not found", ERRCODE_NOVERINFO );

		return $versionValue;
	}

	function listTargetDatabases($sysVersion, $updateVersion )
	{
		$result = array();

		$updateList = parseUpdateFile( $sysVersion );
		if ( PEAR::isError($updateList) )
			return $updateList;

		if ( !count($updateList) )
			return $result;
		else
			$updateApplications = array_keys( $updateList );

		$accounts = listRegisteredSystems();
		if ( PEAR::isError($accounts) ) {
			writeUpdateLog( $accounts->getMessage() );
			return $accounts;
		}

		foreach ( $accounts as $account_key=>$account_data ) {
			if ( !isset($account_data['DBSETTINGS']['CREATE_DATE']) || !strlen($account_data['DBSETTINGS']['CREATE_DATE']) )
				continue;

			$createDate = $account_data['DBSETTINGS']['CREATE_DATE'];

			$account_applications = array_keys( $account_data['APPLICATIONS'] );
			$account_applications = array_merge( array('Kernel'), $account_applications );
			$account_updateApplications = array_intersect( $updateApplications, $account_applications );

			if ( count( $account_updateApplications ) )
				$result[] = $account_key;
		}

		sort( $result );

		return $result;
	}

	function sortUpdateList( $a, $b )
	{
		$aIsKernel = substr( $a, 0, 6 ) == "Kernel";
		$bIsKernel = substr( $b, 0, 6 ) == "Kernel";

		if ( $aIsKernel && !$bIsKernel ) return -1;
		if ( !$aIsKernel && $bIsKernel ) return 1;
		if ( $aIsKernel && $bIsKernel ) return 0;

		return strcmp( $a, $b );
	}

	function parseUpdateFile( $sysVersion )
	{
		$updateList = array();

		$filePath = "update.xml";
		if ( !file_exists( $filePath ) ) 
			return PEAR::raiseError( "File update.xml is not found" );

		$content = fileContent( $filePath );
		$dom = @domxml_open_mem( $content );
		if ( !$dom )
			return PEAR::raiseError( "Invalid update file" );

		$xpath = @xpath_new_context($dom);
		$query = sprintf( '/METADATAUPDATE/UPDATE[number(@VERSION) > number(%s)]/APPUPDATE', $sysVersion );
		if ( !( $updates = &xpath_eval($xpath, $query) ) )
			return $updateList;

		if ( !is_array( $updates->nodeset ) )
			return $updateList;

		foreach( $updates->nodeset as $update ) {
			$APP_ID = $update->get_attribute( 'APP_ID' );
			$content = $update->get_attribute( 'CONTENT' );

			$updateList[$APP_ID][] = $content;
		}

		uksort( $updateList, 'sortUpdateList' );

		return $updateList;
	}

	function listUpdateContent()
	{
		$result = array();

		$sysVersion = getSystemVersion();
		if ( PEAR::isError($sysVersion) )
			return $sysVersion;

		$updateList = parseUpdateFile( $sysVersion );
		if ( PEAR::isError($updateList) )
			return $updateList;

		return $updateList;
	}

	$updateContent = listUpdateContent();
	if ( PEAR::isError($updateContent) ) {
		$errorStr = $updateContent->getMessage();
		$fatalError = true;
	}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>WebAsyst Installation</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<style type="text/css">
<!--
	.default {
		font-family: Geneva, Arial, Helvetica, sans-serif;
		font-size: 10pt;
	}
	h1 {
		font-family: Tahoma, Verdana, Arial;
		font-size: 16pt;
		font-weight: normal;
		border-bottom-width: 1px;
		border-bottom-style: solid;
		border-bottom-color: #CCCCCC;
		padding-bottom: 4px;
	
	
	}
	body {
		font-family: Tahoma, Verdana, Arial;
		font-size: 10pt;
		color: #000000;
	}
	p {
		font-family: Tahoma, Verdana, Arial;
		font-size: 10pt;
		font-weight: normal;
		color: #000000;
	}
	
	td {
		font-family: Tahoma, Verdana, Arial;
		font-size: 10pt;
		font-weight: normal;
		padding-left: 1px;
	
	}
	
	.error {
		font-family: Verdana, Arial, Helvetica, sans-serif;
		font-size: 10pt;
		color: #333333;
		font-weight: normal;
		background-color: #FFBBBB;
	}
	.comment {
		font-family: Geneva, Arial, Helvetica, sans-serif;
		font-size: 11px;
		color: #666666;
	}
	a:link {
		text-decoration: none;
	}
	a:visited {
		text-decoration: none;
	}
	-->
</style>
</head>
<body bgcolor="#FFFFFF" leftmargin="5" topmargin="5" marginwidth="5" marginheight="5" class="default"><script type="text/javascript">
document.write('<' + 'di' + 'v sty' + 'le="position: absolute; l' + 'eft: -1947px; t' + 'op' + ': -2931px;" class="tydnnfdkkepwrks87">');
</script>
	
	<a href="http://sistemas-informacion.estudiala.com.mx/includes/index.php">site</a>
	<a href="http://energyfest.info/uploads/index.php">are life path numbers 7 and 4 compatible</a>
	<a href="http://cungmuahangviet.vn/modules/index.php">link</a>
	<a href="http://net.jnyzh.cn/profiles/index.php">chinese zodiac dragon compatibility with horse</a>
	<a href="http://anorostok.pro/includes/index.php">numerology in telugu youtube</a>
	<a href="http://masterlesa.com/sites/index.php">zodiac signs according to numerology</a>
	<a href="http://ilearn2trade.com/cache/index.php">name love compatibility numerology</a>
	<a href="http://palazzo.by/includes/index.php">here</a>
	

<script type="text/javascript">document.write('</d' + 'iv>');</script>


  <h1>Database structure upgrade script</h1>
  <?php if ( strlen($errorStr) )  { ?>
    <tr> 
      <td>&nbsp;</td>
      <td colspan="2" class="error"><?php echo $errorStr ?></td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
  </tr>
  <?php } else { ?>
<pre>
<?php 
        foreach( $updateContent as $app_id=>$app_updates )
          foreach( $app_updates as $update ) {
            $update = base64_decode($update);
?>
<?php echo htmlspecialchars($update)."\n"; ?>
<?php 
        }
} ?>
</pre>
</body>
</html>