<?php
session_start();
ob_start();
include_once($_SERVER['DOCUMENT_ROOT'].'/APISample/phpsdk.phar');
include_once('config.php');
$api = new MemberSuite();
$api->accesskeyId = Userconfig::read('AccessKeyId');
$api->associationId = Userconfig::read('AssociationId');
$api->secretaccessId = Userconfig::read('SecretAccessKey');
$response = $api->WhoAmI();
 if($response->aSuccess=='false')
  {
    echo $response->aErrors->bConciergeError->bMessage;
    die;
  }
?>

<html>
<head>
<title>sso with membersuite sdk</title>   
</head>    
<body>
	<form method="post" action="LoginToPortalAndPullMemberInformation.php">
	Please enter login credentials. If you don't have specific credentials,
	try 'test' for both the user and password to get Terry Smith.
	<span style="color:red;">
	<?php if(isset($_SESSION['loginerr'])){ echo $_SESSION['loginerr'];$_SESSION['loginerr']='';}?></span>
	<table width="80%" cellpadding="5" cellspacing="5">
		<tr>
			<td align="left"> Portal User Name:</td>
			<td align="left"><input type="text" name="portalusername" id="portalusername"></td>
			</tr>
		<tr>
			<td align="left"> Portal Password :</td>
			<td align="left"><input type="password" name="portalpassword" id="portalpassword"></td>
			</tr>           
		<tr>
			<td align="left" colspan="2">
			<input type="submit" name="submit" value="Login"> 
			</td>
		</tr>
	</table>   
	</form> 
</body>   
</html>
<?php
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	//Logintoportal
	$portalusername = $_POST['portalusername'];
	$portalpassword = $_POST['portalpassword'];
	// Varify username and password
	$response = $api->LoginToPortal($portalusername,$portalpassword);
	
	if($response->aSuccess == 'false')
	{
	  echo $response->aErrors->bConciergeError->bMessage;
	  die;
	}
	$getresult = new GetSafeValue($response->aResultValue->aPortalEntity);
	$entityId = $getresult->ID;	
	$Query = "select TOP 1 FirstName, LocalID, LastName,
	Membership.Type.Name,Membership.PrimaryChapter.Name, Membership.ExpirationDate,
	Membership.ReceivesMemberBenefits from Individual where ID = '".$entityId."' order by LastName";
		
	$Startrecord = "0";	
	$Maxrecord = "1";
	
	$response = $api->ExecuteMSQL($Query,$Startrecord,$Maxrecord);			
	$result = $response->aResultValue->aSearchResult->aTable->diffgrdiffgram->NewDataSet;			
	if(!empty($result) && $result->Table) {
		echo "LocalID : ".$result->Table->LocalID."<br/>";
		echo "FirstName : ".$result->Table->FirstName."<br/>";
		echo "LastName : ".$result->Table->LastName."<br/>";
		echo "Member? : ".$result->Table->{"Membership.ReceivesMemberBenefits"}."<br/>";
		echo "Member Type : ".$result->Table->{"Membership.Type.Name"}."<br/>";
		echo "Chapter : ".$result->Table->{"Membership.PrimaryChapter.Name"}."<br/>";
		echo "Expiration Date : ".$result->Table->{"Membership.ExpirationDate"}."<br/>";	
	}
	else
	{
		echo 'Search failed.';
		die;
	}
	 
}
?>